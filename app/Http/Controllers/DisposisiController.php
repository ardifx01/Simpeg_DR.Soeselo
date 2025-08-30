<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Disposisi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Disposisi::with('penandatangan');

        // Pencarian berdasarkan nomor surat, hal, dan data penandatangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'like', "%$search%")
                    ->orWhere('hal', 'like', "%$search%")
                    ->orWhereHas('penandatangan', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('nip', 'like', "%$search%");
                    });
            });
        }

        // Eksekusi kueri dengan paginasi dan urutan terbaru
        $disposisis = $query->latest()->paginate(10)->appends($request->query());
        
        return view('surat.disposisi.index', compact('disposisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pegawai untuk dropdown penandatangan
        $pegawais = Pegawai::all();
        
        // Pilihan untuk ENUM dan JSON
        $sifat_options = ['sangat_segera', 'segera', 'rahasia'];
        $harap_options = ['tanggapan dan saran', 'proses lebih lanjut', 'koordinasi/konfirmasikan'];

        return view('surat.disposisi.create', compact('pegawais', 'sifat_options', 'harap_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'surat_dari' => 'required|string',
            'no_surat' => 'required|string|unique:disposisis',
            'tgl_surat' => 'required|date_format:d-m-Y',
            'tgl_diterima' => 'required|date_format:d-m-Y',
            'no_agenda' => 'required|string',
            'sifat' => 'required|in:sangat_segera,segera,rahasia',
            'hal' => 'required|string',
            'diteruskan_kepada' => 'required|array',
            'diteruskan_kepada.*' => 'nullable|exists:pegawais,id',
            'harap' => 'required|array',
            'catatan' => 'nullable|string',
            'penandatangan_id' => 'required|exists:pegawais,id',
        ]);

        // Konversi tanggal dari format dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan
        $validatedData['tgl_surat'] = Carbon::createFromFormat('d-m-Y', $validatedData['tgl_surat'])->format('Y-m-d');
        $validatedData['tgl_diterima'] = Carbon::createFromFormat('d-m-Y', $validatedData['tgl_diterima'])->format('Y-m-d');

        Disposisi::create($validatedData);

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposisi $disposisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi $disposisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi $disposisi)
    {
        $disposisi->delete();
        return back()->with('success', 'Disposisi dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $disposisis = Disposisi::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('hal', 'like', "%{$search}%")
                    ->orWhere('no_surat', 'like', "%{$search}%")
                    ->orWhere('sifat', 'like', "%{$search}%")
                    ->orWhereHas('penandatangan', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('disposisi.trash', compact('disposisis', 'search'));
    }

    public function restore($id)
    {
        $disposisi = Disposisi::onlyTrashed()->findOrFail($id);
        $disposisi->restore();

        return back()->with('success', 'Disposisi berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $disposisi = Disposisi::onlyTrashed()->findOrFail($id);
        $disposisi->forceDelete();

        return back()->with('success', 'Disposisi dihapus permanen.');
    }

    public function export($id)
    {
        $disposisi = Disposisi::with('penandatangan.jabatan')->findOrFail($id);
        
        $templatePath = storage_path('app/templates/disposisi_template.docx');

        if (!file_exists($templatePath)) {
            return back()->with('error', 'File template disposisi_template.docx tidak ditemukan!');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            $templateProcessor->setValue('surat_dari', $disposisi->surat_dari ?? '-');
            $templateProcessor->setValue('no_surat', $disposisi->no_surat ?? '-');
            $templateProcessor->setValue('tgl_surat', $disposisi->tgl_surat ? Carbon::parse($disposisi->tgl_surat)->format('d-m-Y') : '-');
            $templateProcessor->setValue('tgl_diterima', $disposisi->tgl_diterima ? Carbon::parse($disposisi->tgl_diterima)->format('d-m-Y') : '-');
            $templateProcessor->setValue('no_agenda', $disposisi->no_agenda ?? '-');
            $templateProcessor->setValue('hal', $disposisi->hal ?? '-');
            $templateProcessor->setValue('catatan', $disposisi->catatan ?? '-');

            // --- CHECKBOX SIFAT ---
            $templateProcessor->setValue('check_sangat_segera', $disposisi->sifat === 'sangat_segera' ? '✔' : '');
            $templateProcessor->setValue('check_segera',        $disposisi->sifat === 'segera' ? '✔' : '');
            $templateProcessor->setValue('check_rahasia',      $disposisi->sifat === 'rahasia' ? '✔' : '');

            // --- CHECKBOX HARAP ---
            $harap_data = $disposisi->harap;
            $harap_options = is_string($harap_data) ? json_decode($harap_data, true) : $harap_data;
            $harap_options = $harap_options ?? [];

            $templateProcessor->setValue('check_tanggapan', in_array('tanggapan dan saran', $harap_options) ? '✔' : '');
            $templateProcessor->setValue('check_proses', in_array('proses lebih lanjut', $harap_options) ? '✔' : '');
            $templateProcessor->setValue('check_koordinasi', in_array('koordinasi/konfirmasikan', $harap_options) ? '✔' : '');

            $diteruskan_data = $disposisi->diteruskan_kepada;
            $diteruskan_ids = is_string($diteruskan_data) ? json_decode($diteruskan_data, true) : $diteruskan_data;
            $diteruskan_ids = $diteruskan_ids ?? []; // Pastikan tidak null
            if (!empty($diteruskan_ids)) {
                $diteruskan_names = Pegawai::whereIn('id', $diteruskan_ids)->pluck('nama')->toArray();
                $diteruskanList = new TextRun();
                foreach ($diteruskan_names as $index => $nama) {
                    if ($index > 0) $diteruskanList->addTextBreak();
                    $diteruskanList->addText('- ' . $nama);
                }
                $templateProcessor->setComplexBlock('diteruskan_kepada', $diteruskanList);
            } else {
                $templateProcessor->setValue('diteruskan_kepada', '-');
            }

            $penandatangan = $disposisi->penandatangan;
            if ($penandatangan) {
                $templateProcessor->setValue('jabatan_penandatangan', optional($penandatangan->jabatan)->nama_jabatan ?? '-');
                $templateProcessor->setValue('nama_penandatangan', $penandatangan->nama ?? '-');
                // Menggunakan accessor pangkat_golongan yang sudah kamu buat
                $pangkatNip = ($penandatangan->pangkat_golongan ?? '') . ' NIP. ' . ($penandatangan->nip ?? '-');
                $templateProcessor->setValue('penandatangan_pangkat_nip', $pangkatNip);
            } else {
                // Fallback jika tidak ada data penandatangan
                $templateProcessor->setValue('jabatan_penandatangan', '-');
                $templateProcessor->setValue('nama_penandatangan', '-');
                $templateProcessor->setValue('penandatangan_pangkat_nip', 'NIP. -');
            }

            // Simpan file sementara
            $fileName = 'disposisi_' . Str::slug($disposisi->no_surat, '_') . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $templateProcessor->saveAs($tempFile);

            // Kirim file ke browser untuk diunduh
            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor file: ' . $e->getMessage());
        }
    }
}
