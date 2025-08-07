<?php

namespace App\Http\Controllers;

use App\Models\Hukuman;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class HukumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hukuman::query()->with('pegawai.jabatan');

        // Filter berdasarkan pegawai
        if ($request->has('pegawai_id') && $request->pegawai_id != 'all') {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan hukuman
        if ($request->has('jenis_hukuman') && $request->jenis_hukuman != 'all') {
            $query->where('jenis_hukuman', $request->jenis_hukuman);
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
                ->orWhere('jenis_hukuman', 'like', "%$search%");
            });
        }

        $hukumans = $query->latest()->paginate(10)->appends($request->query());
        return view('surat.hukuman.index', compact('hukumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.hukuman.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bentuk_pelanggaran' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'faktor_meringankan' => 'required|string',
            'faktor_memberatkan' => 'required|string',
            'dampak' => 'required|string',
            'pwkt' => 'required|string|max:255',
            'no' => 'required|string|max:255',
            'tahun' => 'required|integer|digits:4',
            'pasal' => 'required|string|max:255',
            'tentang' => 'required|string',
            'jenis_hukuman' => 'required|string|max:255',
            'keterangan_hukuman' => 'required|string',
            'peraturan' => 'required|string',
            'hari' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i:s',
            'atasan_id' => 'required|exists:pegawais,id',
        ]);

        // Mengambil semua data yang sudah divalidasi
        $data = $validatedData;

        // Ambil data atasan pegawai berdasarkan atasan_id yang dipilih.
        $atasanPegawai = Pegawai::with('jabatan')->find($data['atasan_id']);

        if ($atasanPegawai) {
            // Isi kolom-kolom atasan di tabel 'hukumen' dari data atasan pegawai yang ditemukan.
            $data['atasan_nama'] = $atasanPegawai->nama_lengkap;
            $data['atasan_nip'] = $atasanPegawai->nip;
            $data['atasan_jabatan'] = $atasanPegawai->jabatan?->nama_jabatan;
            $data['atasan_pangkat'] = $atasanPegawai->pangkat ?? null;
            $data['atasan_golongan_ruang'] = $atasanPegawai->golongan_ruang ?? null;
        } else {
            // Jika atasan tidak ditemukan, set nilai-nilai atasan ke null.
            $data['atasan_nama'] = null;
            $data['atasan_nip'] = null;
            $data['atasan_jabatan'] = null;
            $data['atasan_pangkat'] = null;
            $data['atasan_golongan_ruang'] = null;
        }

        unset($data['atasan_id']);

        Hukuman::create($data);

        return redirect()->route('hukuman.index')->with('success', 'Pengajuan surat hukuman berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hukuman $hukuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hukuman $hukuman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hukuman $hukuman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hukuman $hukuman)
    {
        //
    }

    public function export($id)
    {
        $hukuman = hukuman::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/hukuman_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama', $hukuman->pegawai->nama);
        $template->setValue('nip', $hukuman->pegawai->nip);
        $template->setValue('pangkat', $hukuman->pegawai->jabatan->pangkat ?? '-');
        $template->setValue('golongan_ruang', $hukuman->pegawai->golongan_ruang ?? '-');
        $template->setValue('jabatan', $hukuman->pegawai->jabatan->nama_jabatan ?? '-');
        $template->setValue('unit_kerja', $hukuman->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('atasan_nama', $hukuman->atasan_nama ?? '-');
        $template->setValue('atasan_jabatan', $hukuman->atasan_jabatan ?? '-');
        $template->setValue('atasan_nip', $hukuman->atasan_nip ?? '-');
        $template->setValue('atasan_pangkat', $hukuman->atasan_pangkat ?? '-');
        $template->setValue('atasan_golongan_ruang', $hukuman->atasan_golongan_ruang ?? '-');
        $template->setValue('bentuk_pelanggaran', $hukuman->bentuk_pelanggaran);
        $template->setValue('waktu', $hukuman->waktu);
        $template->setValue('tempat', $hukuman->tempat);
        $template->setValue('faktor_meringankan', $hukuman->faktor_meringankan);
        $template->setValue('faktor_memberatkan', $hukuman->faktor_memberatkan);
        $template->setValue('dampak', $hukuman->dampak);
        $template->setValue('waktu', $hukuman->waktu);
        $template->setValue('pwkt', $hukuman->pwkt);
        $template->setValue('no', $hukuman->no);
        $template->setValue('tahun', $hukuman->tahun);
        $template->setValue('pasal', $hukuman->pasal);
        $template->setValue('tentang', $hukuman->tentang);
        $template->setValue('jenis_hukuman', $hukuman->hukuman);
        $template->setValue('keterangan_hukuman', $hukuman->keterangan_hukuman);
        $template->setValue('peraturan', $hukuman->peraturan);
        $template->setValue('hari', $hukuman->hari);
        $template->setValue('tanggal', $hukuman->tanggal);
        $template->setValue('jam', $hukuman->jam);

        $filename = 'surat_hukuman_' . str_replace(' ', '_', strtolower($hukuman->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
