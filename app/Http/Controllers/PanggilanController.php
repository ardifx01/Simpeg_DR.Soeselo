<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Panggilan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class PanggilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Biarkan query builder tetap aktif
        $query = Panggilan::with(['pegawai', 'penandatangan']);

        // Pencarian dengan relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                  ->orWhere('perihal', 'like', "%$search%")
                  ->orWhere('sifat', 'like', "%$search%")
                  ->orWhere('menghadap_kepada', 'like', "%$search%")
                  ->orWhere('alamat_menghadap', 'like', "%$search%")
                  ->orWhere('jadwal_hari', 'like', "%$search%")
                  ->orWhere('jadwal_pukul', 'like', "%$search%")
                  // cari di relasi pegawai yang dipanggil
                  ->orWhereHas('pegawai', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%")
                        ->orWhere('gelar_depan', 'like', "%$search%")
                        ->orWhere('gelar_belakang', 'like', "%$search%");
                })
                  // cari di relasi penandatangan
                ->orWhereHas('penandatangan', function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%")
                        ->orWhere('gelar_depan', 'like', "%$search%")
                        ->orWhere('gelar_belakang', 'like', "%$search%");
                });
            });
        }

        // Eksekusi kueri hanya di akhir
        $panggilans = $query->latest('tanggal_surat') ->paginate(10)->appends($request->query());

        return view('surat.panggilan.index', compact('panggilans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pegawai untuk dropdown
        $pegawais = Pegawai::with('jabatan')->orderBy('nama')->get();

        return view('surat.panggilan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id'        => 'required|exists:pegawais,id',
            'penandatangan_id'  => 'required|exists:pegawais,id',

            'nomor_surat'       => 'required|string|max:191|unique:panggilans,nomor_surat',
            'sifat'             => 'required|string|max:50',
            'lampiran'          => 'nullable|string|max:191',
            'tanggal_surat'     => 'required|date_format:d-m-Y', 
            'perihal'           => 'required|string',

            'jadwal_hari'       => 'required|string|max:50',
            'jadwal_tanggal'    => 'required|date_format:d-m-Y', 
            'jadwal_pukul'      => 'required|string|max:50',
            'jadwal_tempat'     => 'required|string|max:191',
            'menghadap_kepada'  => 'required|string|max:191',
            'alamat_menghadap'  => 'required|string|max:191',
            'tembusan'          => 'nullable|string',
        ]);

        // Konversi tanggal dari dd-mm-yyyy ke YYYY-MM-DD
        foreach (['tanggal_surat', 'jadwal_tanggal'] as $field) {
            if (!empty($validated[$field])) {
                try {
                    $validated[$field] = Carbon::createFromFormat('d-m-Y', $validated[$field])->format('Y-m-d');
                } catch (\Throwable $e) {
                    $validated[$field] = Carbon::parse($validated[$field])->format('Y-m-d');
                }
            }
        }

        Panggilan::create($validated);

        return redirect()->route('panggilan.index')->with('success', 'Surat Panggilan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export($id)
    {
        $panggilan = Panggilan::with(['pegawai.jabatan', 'penandatangan.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/panggilan_template.docx'));

        // Detail surat
        $template->setValue('nomor', $panggilan->nomor_surat ?? '-');
        $template->setValue('sifat', $panggilan->sifat ?? '-');
        $template->setValue('lampiran', $panggilan->lampiran ?? '-');
        $template->setValue('tanggal', $panggilan->tanggal_surat->translatedFormat('d F Y'));
        $template->setValue('perihal', $panggilan->perihal ?? '-');

        // Jadwal
        $template->setValue('jadwal_hari', $panggilan->jadwal_hari ?? '-');
        $template->setValue('jadwal_tanggal', $panggilan->jadwal_tanggal->translatedFormat('d F Y'));
        $template->setValue('jadwal_pukul', $panggilan->jadwal_pukul ?? '-');
        $template->setValue('jadwal_tempat', $panggilan->jadwal_tempat ?? '-');
        $template->setValue('menghadap_kepada', $panggilan->menghadap_kepada ?? '-');
        $template->setValue('alamat_menghadap', $panggilan->alamat_menghadap ?? '-');

        // Pegawai yang dipanggil (pakai accessor nama_lengkap)
        $pgw = $panggilan->pegawai;
        $template->setValue('nama_pegawai', optional($pgw)->nama_lengkap ?? '-');
        $template->setValue('nip_pegawai', optional($pgw)->nip ?? '-');
        $template->setValue('jabatan_pegawai', optional(optional($pgw)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_pegawai', optional($pgw)->pangkat_golongan ?? '-');

        // Penandatangan (pakai accessor nama_lengkap)
        $ttd = $panggilan->penandatangan;
        $template->setValue('nama_penandatangan', optional($ttd)->nama_lengkap ?? '-');
        $template->setValue('nip_penandatangan', optional($ttd)->nip ?? '-');
        $template->setValue('jabatan_penandatangan', optional(optional($ttd)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('pangkat_penandatangan', optional($ttd)->pangkat_golongan ?? '-');

        // Tembusan (text dipisah koma → list bernomor)
        if (!empty($panggilan->tembusan)) {
            $items = array_values(array_filter(array_map('trim', explode(',', $panggilan->tembusan))));
            if (count($items)) {
                $tr = new TextRun();
                foreach ($items as $i => $item) {
                    if ($i > 0) $tr->addTextBreak();
                    $tr->addText(($i + 1) . '. ' . $item);
                }
                $template->setComplexBlock('tembusan', $tr);
            } else {
                $template->setValue('tembusan', '-');
            }
        } else {
            $template->setValue('tembusan', '-');
        }

        // Nama file
        $namaPgw = optional($pgw)->nama_lengkap ?? 'tanpa_nama';
        $filename = 'surat_panggilan_' . Str::slug($namaPgw, '_') . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
