<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        // Validasi data yang masuk dari request
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'atasan_id' => 'required|exists:pegawais,id',
            'program' => 'required|string|max:255',
            'lembaga' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
        ]);

        // Mengambil semua data yang sudah divalidasi
        $data = $validatedData;

        // Ambil data atasan pegawai berdasarkan atasan_id yang dipilih
        $atasanPegawai = Pegawai::with('jabatan')->find($data['atasan_id']);

        if ($atasanPegawai) {
            // Mengisi kolom-kolom atasan dari data pegawai yang ditemukan
            $data['atasan_nama'] = $atasanPegawai->nama_lengkap;
            $data['atasan_nip'] = $atasanPegawai->nip;
            $data['atasan_pangkat'] = $atasanPegawai->pangkat ?? null;
            $data['atasan_golongan_ruang'] = $atasanPegawai->golongan_ruang ?? null;
            $data['atasan_jabatan'] = $atasanPegawai->jabatan?->nama_jabatan;
        }

        unset($data['atasan_id']);

        TugasBelajar::create($data);

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

        $template->setValue('nama_pegawai', $tugasbelajar->pegawai->nama_lengkap ?? '-');
        $template->setValue('nip_pegawai', $tugasbelajar->pegawai->nip ?? '-');
        $template->setValue('pangkat_pegawai', $tugasbelajar->pegawai->pangkat ?? '-');
        $template->setValue('golongan_ruang_pegawai', $tugasbelajar->pegawai->golongan_ruang ?? '-');
        $template->setValue('jabatan_pegawai', $tugasbelajar->pegawai->jabatan->nama_jabatan ?? '-');
        $template->setValue('unit_kerja_pegawai', $tugasbelajar->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('tempat_lahir_pegawai', $tugasbelajar->pegawai->tempat_lahir ?? '-');
        $tanggalLahir = $tugasbelajar->pegawai->tanggal_lahir;
        $tanggalLahirFormatted = $tanggalLahir ? Carbon::parse($tanggalLahir)->translatedFormat('d F Y') : '-';
        $template->setValue('tanggal_lahir_pegawai', $tanggalLahirFormatted);
        $usia = $tanggalLahir ? Carbon::parse($tanggalLahir)->age : '-';
        $template->setValue('usia_pegawai', $usia);        $template->setValue('alamat_pegawai', $tugasbelajar->pegawai->alamat_lengkap ?? '-');
        $template->setValue('telepon_pegawai', $tugasbelajar->pegawai->telepon ?? '-');
        $template->setValue('pendidikan_pegawai', $tugasbelajar->pegawai->pendidikan->tingkat ?? '-');
        $template->setValue('program', $tugasbelajar->program ?? '-');
        $template->setValue('lembaga', $tugasbelajar->lembaga ?? '-');
        $template->setValue('fakultas', $tugasbelajar->fakultas ?? '-');
        $template->setValue('program_studi', $tugasbelajar->program_studi ?? '-');
        $template->setValue('nama_atasan', $tugasbelajar->atasan->nama_lengkap ?? '-');
        $template->setValue('nip_atasan', $tugasbelajar->atasan->nip ?? '-');
        $template->setValue('nip_unit_kerja', $tugasbelajar->atasan->unit_kerja ?? '-');
        $template->setValue('pangkat_atasan', $tugasbelajar->atasan->pangkat ?? '-');
        $template->setValue('golongan_ruang_atasan', $tugasbelajar->atasan->golongan_ruang ?? '-');
        $template->setValue('jabatan_atasan', $tugasbelajar->atasan->jabatan->nama_jabatan ?? '-');

        $filename = 'surat_tugas_belajar_' . str_replace(' ', '_', strtolower($tugasbelajar->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
