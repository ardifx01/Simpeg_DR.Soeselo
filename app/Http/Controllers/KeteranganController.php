<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Keterangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class KeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keterangan::query()->with('pegawai.jabatan');

        // Filter berdasarkan pegawai
        if ($request->has('pegawai_id') && $request->pegawai_id != 'all') {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan keterangan
        if ($request->has('jenis_keterangan') && $request->jenis_keterangan != 'all') {
            $query->where('jenis_keterangan', $request->jenis_keterangan);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari di relasi pegawai
                $q->whereHas('pegawai', function ($pegawai) use ($search) {
                    $pegawai->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                })
                // Atau di tugas belajar
                ->orWhere('jenis_keterangan', 'like', "%$search%");
            });
        }

        $keterangans = $query->latest()->paginate(10)->appends($request->query());
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
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis_keterangan' => 'required',
            'nama' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'hubungan' => 'nullable|string|max:255',
            'status_rawat' => 'nullable|string|max:255',
        ]);

        Keterangan::create($request->all());

        return redirect()->route('keterangan.index')->with('success', 'Pengajuan surat keterangan berhasil!');
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
        //
    }

    public function export($id)
    {
        $keterangan = Keterangan::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/keterangan_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama_pegawai', $keterangan->pegawai->nama);
        $template->setValue('nip', $keterangan->pegawai->nip ?? '-');
        $template->setValue('tempat_lahir_pegawai', $keterangan->pegawai->tempat_lahir ?? '-');
        $template->setValue('tanggal_lahir_pegawai', \Carbon\Carbon::parse($keterangan->pegawai->tanggal_lahir)->format('d-m-Y'));
        $template->setValue('jabatan', $keterangan->pegawai->jabatan->nama_jabatan ?? '-');
        $template->setValue('pendidikan', $keterangan->pegawai->pendidikan->tingkat ?? '-');
        $template->setValue('alamat_pegawai', $keterangan->pegawai->alamat ?? '-');
        $template->setValue('unit_kerja', $keterangan->pegawai->jabatan->unit_kerja ?? '-');
        $status = $keterangan->pegawai->jabatan->jenis_kepegawaian ?? null;
        $statusFinal = in_array($status, ['PNS', 'PPPK', 'CPNS']) ? 'ASN' : ($status === 'BLUD' ? 'BLUD' : '-');
        $template->setValue('status', $statusFinal);
        $template->setValue('status_rawat', $keterangan->status_rawat);
        $template->setValue('nama', $keterangan->nama);
        $template->setValue('nik', $keterangan->nik ?? '-');
        $template->setValue('tempat_lahir', $keterangan->tempat_lahir ?? '-');
        $template->setValue('tanggal_lahir', \Carbon\Carbon::parse($keterangan->tanggal_lahir)->format('d-m-Y'));
        $template->setValue('agama', $keterangan->agama ?? '-');
        $template->setValue('alamat', $keterangan->alamat);
        $template->setValue('pekerjaan', $keterangan->pekerjaan);
        $template->setValue('hubungan', ucfirst($keterangan->hubungan));

        $filename = 'surat_keterangan_' . str_replace(' ', '_', strtolower($keterangan->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
