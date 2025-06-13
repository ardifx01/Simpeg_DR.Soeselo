<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\TugasBelajar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class TugasBelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TugasBelajar::query()->with('pegawai.jabatan');

        // Filter berdasarkan pegawai
        if ($request->has('pegawai_id') && $request->pegawai_id != 'all') {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan program
        if ($request->has('program') && $request->program != 'all') {
            $query->where('program', $request->program);
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
                ->orWhere('program', 'like', "%$search%");
            });
        }

        $tugasbelajars = $query->latest()->paginate(10)->appends($request->query());
        return view('surat.tugas_belajar.index', compact('tugasbelajars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.tugas_belajar.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'program' => 'required',
            'lembaga' => 'required',
            'fakultas' => 'required',
            'program_studi' => 'required',
        ]);

        tugasbelajar::create($request->all());

        return redirect()->route('tugas_belajar.index')->with('success', 'Pengajuan surat tugas belajar berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TugasBelajar $tugasBelajar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TugasBelajar $tugasBelajar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TugasBelajar $tugasBelajar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TugasBelajar $tugasBelajar)
    {
        //
    }

    public function export($id)
    {
        $tugasbelajar = TugasBelajar::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/tugas_belajar_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama', $tugasbelajar->pegawai->nama);
        $template->setValue('nip', $tugasbelajar->pegawai->nip);
        $template->setValue('golongan_ruang', $tugasbelajar->pegawai->golongan_ruang ?? '-');
        $template->setValue('tempat_lahir', $tugasbelajar->pegawai->tempat_lahir ?? '-');
        $template->setValue('tanggal_lahir', $tugasbelajar->pegawai->tanggal_lahir ?? '-');
        $template->setValue('alamat', $tugasbelajar->pegawai->alamat ?? '-');
        $template->setValue('telepon', $tugasbelajar->pegawai->telepon ?? '-');
        $template->setValue('pendidikan', $tugasbelajar->pegawai->pendidikan->tingkat ?? '-');
        $template->setValue('pangkat', $tugasbelajar->pegawai->jabatan->nama ?? '-');
        $template->setValue('jabatan', $tugasbelajar->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('unit_kerja', $tugasbelajar->pegawai->jabatan->skpd ?? '-');
        $template->setValue('program', $tugasbelajar->program);
        $template->setValue('lembaga', $tugasbelajar->lembaga);
        $template->setValue('fakultas', $tugasbelajar->fakultas);
        $template->setValue('program_studi', $tugasbelajar->program_studi);

        $filename = 'surat_tugas_belajar_' . str_replace(' ', '_', strtolower($tugasbelajar->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
