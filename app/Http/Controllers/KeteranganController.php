<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Keterangan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\TemplateProcessor;

class KeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keterangan::with(['pegawai', 'penandatangan']);

        // Logika pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($subQuery) use ($search) {
                        $subQuery->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('penandatangan', function ($subQuery) use ($search) {
                        $subQuery->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Eksekusi query dengan paginasi
        $keterangans = $query->latest()->paginate(10)->withQueryString();
        
        return view('surat.keterangan.index', compact('keterangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.keterangan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari formulir
        $validatedData = $request->validate([
            'nomor' => 'nullable|string|max:255|unique:keterangans,nomor',
            'pegawai_id' => 'required|exists:pegawais,id',
            'keterangan' => 'required|string',
            'tanggal_ditetapkan' => 'required|date_format:d-m-Y',
            'penandatangan_id' => 'required|exists:pegawais,id',
            'tembusan' => 'nullable|string',
        ]);

        // Konversi format tanggal dari dd-mm-yyyy ke Y-m-d
        $validatedData['tanggal_ditetapkan'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_ditetapkan'])->format('Y-m-d');

        // Simpan data ke database
        Keterangan::create($validatedData);

        return redirect()->route('keterangan.index')->with('success', 'Surat Keterangan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keterangan $keterangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keterangan $keterangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keterangan $keterangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keterangan $keterangan)
    {
        $keterangan->delete();
        return back()->with('success', 'Surat keterangan dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $keterangans = Keterangan::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    )
                    ->orWhereHas('penandatangan', fn($qt) =>
                            $qt->where('nama', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('keterangan.trash', compact('keterangans', 'search'));
    }

    public function restore($id)
    {
        $keterangan = Keterangan::onlyTrashed()->findOrFail($id);
        $keterangan->restore();

        return back()->with('success', 'Surat keterangan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $keterangan = Keterangan::onlyTrashed()->findOrFail($id);
        $keterangan->forceDelete();

        return back()->with('success', 'Surat keterangan dihapus permanen.');
    }

    public function export($id)
    {
        // Ambil data dengan relasi yang dibutuhkan
        $keterangan = Keterangan::with(['pegawai.jabatan', 'penandatangan.jabatan'])->findOrFail($id);
        
        $templatePath = storage_path('app/templates/keterangan_template.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception('File template keterangan_template.docx tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);

        // --- Mengisi Data Utama ---
        $template->setValue('nomor', $keterangan->nomor ?? '...');

        // --- Mengisi Data Penandatangan ---
        $penandatangan = $keterangan->penandatangan;
        $template->setValue('nama_penandatangan', optional($penandatangan)->nama ?? '-');
        $template->setValue('nip_penandatangan', optional($penandatangan)->nip ?? '-');
        $template->setValue('pangkat_penandatangan', optional($penandatangan->jabatan)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_penandatangan', optional($penandatangan->jabatan)->nama_jabatan ?? '-');
        
        // --- Mengisi Data Pegawai yang Diterangkan ---
        $pegawai = $keterangan->pegawai;
        $template->setValue('nama_pegawai', optional($pegawai)->nama ?? '-');
        $template->setValue('nip_pegawai', optional($pegawai)->nip ?? '-');
        $template->setValue('pangkat_pegawai', optional($pegawai)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pegawai', optional($pegawai->jabatan)->nama_jabatan ?? '-');

        // --- Mengisi Keterangan & Tanggal ---
        $template->setValue('keterangan', strip_tags($keterangan->keterangan));
        $template->setValue('tempat_tanggal', 'Slawi, ' . Carbon::parse($keterangan->tanggal_ditetapkan)->translatedFormat('d F Y'));
        
        // --- Mengisi Tembusan ---
        if ($keterangan->tembusan) {
            $tembusanArray = explode(',', $keterangan->tembusan);
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

        // --- Simpan dan Unduh File ---
        $fileName = 'surat_keterangan_' . Str::slug(optional($pegawai)->nama, '_') . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $template->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
