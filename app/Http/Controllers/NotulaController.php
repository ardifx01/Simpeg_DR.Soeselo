<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notula;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class NotulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Biarkan query builder tetap aktif
        $query = Notula::with(['ketua', 'sekretaris', 'pencatat']);

        // Pencarian dengan relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sidang_rapat', 'like', "%$search%")
                  ->orWhere('acara', 'like', "%$search%")
                  ->orWhere('kegiatan_rapat', 'like', "%$search%")
                  ->orWhere('surat_undangan', 'like', "%$search%")
                  ->orWhere('tanggal', 'like', "%$search%")
                  ->orWhere('waktu', 'like', "%$search%")
                  ->orWhereHas('ketua', function ($qq) use ($search) {
                      $qq->where('nama', 'like', "%$search%")
                         ->orWhere('nip', 'like', "%$search%");
                  })
                  ->orWhereHas('sekretaris', function ($qq) use ($search) {
                      $qq->where('nama', 'like', "%$search%")
                         ->orWhere('nip', 'like', "%$search%");
                  })
                  ->orWhereHas('pencatat', function ($qq) use ($search) {
                      $qq->where('nama', 'like', "%$search%")
                         ->orWhere('nip', 'like', "%$search%");
                  });
            });
        }

        // Eksekusi kueri hanya di akhir
        $notulas = $query->latest()->paginate(10)->appends($request->query());

        return view('surat.notula.index', compact('notulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pegawai untuk dropdown
        $pegawais = Pegawai::with('jabatan')->get();

        return view('surat.notula.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sidang_rapat'   => 'required|string|max:191',
            'tanggal'        => 'required|string',         // ikut pola: convert manual ke Y-m-d
            'waktu'          => 'required|date_format:H:i',
            'surat_undangan' => 'nullable|string|max:255',
            'acara'          => 'required|string',
            'ketua_id'       => 'required|exists:pegawais,id',
            'sekretaris_id'  => 'nullable|exists:pegawais,id',
            'pencatat_id'    => 'required|exists:pegawais,id',
            'peserta'        => 'required|array|min:1',
            'peserta.*'      => 'integer|exists:pegawais,id',
            'kegiatan_rapat' => 'required|string',
        ]);

        // Konversi tanggal dari dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan (ikut pola)
        if (!empty($validatedData['tanggal'])) {
            try {
                $validatedData['tanggal'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal'])->format('Y-m-d');
            } catch (\Throwable $e) {
                // fallback kalau form sudah kirim Y-m-d (misal pakai input type="date")
                $validatedData['tanggal'] = Carbon::parse($validatedData['tanggal'])->format('Y-m-d');
            }
        }

        // Normalisasi peserta (unique & reindex) – kolom JSON
        $validatedData['peserta'] = array_values(array_unique($validatedData['peserta']));

        // Simpan data notula
        Notula::create($validatedData);

        return redirect()->route('notula.index')->with('success', 'Notula berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notula $notula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notula $notula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notula $notula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notula $notula)
    {
        //
    }

    public function export($id)
    {
        $notula = Notula::with(['ketua.jabatan', 'sekretaris.jabatan', 'pencatat.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/notula_template.docx'));

        // Field utama
        $template->setValue('sidang_rapat', $notula->sidang_rapat ?? '-');
        $template->setValue('tanggal', Carbon::parse($notula->tanggal)->format('d-m-Y'));
        $template->setValue('waktu', $notula->waktu ? Carbon::parse($notula->waktu)->format('H:i') : '-');
        $template->setValue('surat_undangan', $notula->surat_undangan ?? '-');
        $template->setValue('acara', $notula->acara ?? '-');

        // Ketua
        $ketua = $notula->ketua;
        $template->setValue('nama_ketua', optional($ketua)->nama_lengkap ?? '-');
        $template->setValue('nip_ketua', optional($ketua)->nip ?? '-');
        $template->setValue('jabatan_ketua', optional(optional($ketua)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_ketua', optional($ketua)->pangkat_golongan ?? '-');

        // Sekretaris
        $sek = $notula->sekretaris;
        $template->setValue('nama_sekretaris', optional($sek)->nama_lengkap ?? '-');
        $template->setValue('nip_sekretaris', optional($sek)->nip ?? '-');
        $template->setValue('jabatan_sekretaris', optional(optional($sek)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_sekretaris', optional($sek)->pangkat_golongan ?? '-');

        // Pencatat
        $penc = $notula->pencatat;
        $template->setValue('nama_pencatat', optional($penc)->nama_lengkap ?? '-');
        $template->setValue('nip_pencatat', optional($penc)->nip ?? '-');
        $template->setValue('jabatan_pencatat', optional(optional($penc)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pencatat', optional($penc)->pangkat_golongan ?? '-');

        // Peserta (JSON id pegawai) -> jadikan list bernomor
        $pesertaIds = [];

        if (is_array($notula->peserta)) {
            // Kalau sudah array
            $pesertaIds = $notula->peserta;
        } elseif (!empty($notula->peserta)) {
            // Kalau disimpan sebagai string JSON
            $decoded = json_decode($notula->peserta, true);
            if (is_array($decoded)) {
                $pesertaIds = $decoded;
            }
        }

        if (!empty($pesertaIds)) {
            $pesertaList = Pegawai::whereIn('id', $pesertaIds)
                ->orderBy('nama')
                ->get();

            if ($pesertaList->isNotEmpty()) {
                $tr = new \PhpOffice\PhpWord\Element\TextRun();
                foreach ($pesertaList as $i => $pegawai) {
                    if ($i > 0) $tr->addTextBreak();
                    $tr->addText(($i + 1) . '. ' . $pegawai->nama_lengkap);
                }
                $template->setComplexBlock('peserta', $tr);
            } else {
                $template->setValue('peserta', '-');
            }
        } else {
            $template->setValue('peserta', '-');
        }

        // Kegiatan rapat (isi panjang)
        $template->setValue('kegiatan_rapat', strip_tags($notula->kegiatan_rapat ?? '-'));

        // Nama file mengikuti pola
        $namaKetua = optional($notula->ketua)->nama ?? 'tanpa_nama';
        $filename = 'notula_' . Str::slug($namaKetua, '_') . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
