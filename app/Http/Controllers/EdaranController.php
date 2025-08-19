<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Edaran;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class EdaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Edaran::with('penandatangan');

        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where(function ($q) use ($search) {
                // Mencari di kolom-kolom tabel 'edarans'
                $q->where('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%")
                ->orWhere('tentang', 'like', "%{$search}%")
                
                // Mencari di dalam relasi 'penandatangan' berdasarkan nama pegawai
                ->orWhereHas('penandatangan', function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%");
                });
            });
        }

        $edarans = $query->latest()->paginate(10)->withQueryString();
        
        return view('surat.edaran.index', compact('edarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();

        return view('surat.edaran.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi semua data yang masuk dari formulir
        $validatedData = $request->validate([
            'nomor' => 'nullable|string|max:255|unique:edarans,nomor',
            'tahun' => 'required|digits:4',
            'tentang' => 'required|string|max:255',
            'isi_edaran' => 'required|string',
            'tanggal_ditetapkan' => 'required|date_format:d-m-Y',
            'penandatangan_id' => 'required|exists:pegawais,id',
            'tujuan' => 'required|array',
            'tujuan.*' => 'exists:pegawais,id',
            'tembusan' => 'nullable|string',
        ]);

        // Konversi format tanggal dari dd-mm-yyyy (dari form) ke Y-m-d
        $validatedData['tanggal_ditetapkan'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_ditetapkan'])->format('Y-m-d');

        // Simpan data 
        Edaran::create($validatedData);

        return redirect()->route('edaran.index')->with('success', 'Surat Edaran berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Edaran $edaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edaran $edaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edaran $edaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edaran $edaran)
    {
        //
    }

    public function export($id)
    {
        // Muat relasi yang dibutuhkan secara eksplisit
        $edaran = Edaran::with(['penandatangan.jabatan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/edaran_template.docx'));

        // Mengisi placeholder utama
        $template->setValue('nomor', $edaran->nomor ?? '...');
        $template->setValue('tahun', $edaran->tahun ?? '....');
        $template->setValue('tentang', $edaran->tentang ?? '...');
        
        // Mengisi isi edaran (jika isinya HTML, perlu di-strip tag-nya)
        $isi_edaran_plain = strip_tags($edaran->isi_edaran);
        $template->setValue('isi_edaran', $isi_edaran_plain);

        // Format dan isi tanggal penetapan
        $tanggal_ditetapkan = Carbon::parse($edaran->tanggal_ditetapkan)->translatedFormat('d F Y');
        $template->setValue('tanggal_ditetapkan', $tanggal_ditetapkan);

        // Mengisi data penandatangan
        $penandatangan = $edaran->penandatangan;
        if ($penandatangan) {
            $template->setValue('nama_penandatangan', $penandatangan->nama ?? '-');
            // Menggunakan accessor pangkat_golongan jika ada di model Pegawai
            $pangkatNip = ($penandatangan->pangkat_golongan ?? '') . ' NIP. ' . ($penandatangan->nip ?? '-');
            $template->setValue('pangkat_nip_penandatangan', $pangkatNip);
            // Mengambil nama jabatan dari relasi
            $template->setValue('jabatan_penandatangan', optional($penandatangan->jabatan)->nama_jabatan ?? 'Direktur');
        } else {
            $template->setValue('nama_penandatangan', '-');
            $template->setValue('pangkat_nip_penandatangan', 'NIP. -');
            $template->setValue('jabatan_penandatangan', '-');
        }

        // Mengisi daftar tujuan/penerima (sebagai daftar bernomor)
        $tujuan_ids = $edaran->tujuan ?? [];
        if (!empty($tujuan_ids)) {
            $tujuan_names = Pegawai::whereIn('id', $tujuan_ids)->pluck('nama')->toArray();
            
            // Menggunakan TextRun untuk membuat daftar bernomor dengan baris baru
            $tujuanList = new TextRun();
            foreach ($tujuan_names as $index => $nama) {
                if ($index > 0) {
                    $tujuanList->addTextBreak(); // Pindah baris
                }
                $tujuanList->addText(($index + 1) . '. ' . $nama);
            }
            $template->setComplexBlock('daftar_tujuan', $tujuanList);
        } else {
            $template->setValue('daftar_tujuan', '-');
        }

        if ($edaran->tembusan) {
            $tembusanArray = explode(',', $edaran->tembusan);
            $tr = new TextRun();

            foreach ($tembusanArray as $i => $item) {
                if ($i > 0) {
                    $tr->addTextBreak();
                }
                $tr->addText(($i + 1) . '. ' . trim($item));
            }

            $template->setComplexBlock('tembusan', $tr);
        } else {
            $template->setValue('tembusan', '-');
        }
        
        // Simpan file sementara dan kirim untuk diunduh
        $fileName = 'surat_edaran_' . Str::slug($edaran->tentang, '_') . '.docx';
        
        $path = storage_path("app/public/{$fileName}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
