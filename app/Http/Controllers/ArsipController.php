<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pegawai $pegawai)
    {
        //
    }

    public function arsipView($id) {
        $arsip = Arsip::findOrFail($id);
        return view('dashboard.arsip', compact('arsip'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pegawai $pegawai)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // melakukan validasi data
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis' => 'required|in:SK CPNS,Surat Tugas,Surat Menghadap,Ijazah Pendidikan,Surat Nikah,KTP,NPWP, Kartu Keluarga, Akta Lahir Keluarga, Pas Photo, FIP, Konversi NIP, SK PNS,SK Kenaikan Pangkat, KPE, Karpeg, Taspen, Karis / Karsu, SK Mutasi BKN / Gubernur, ASKES / BPJS, STTPL, Sumpah Jabatan PNS, KGB, Rekomendasi Ijin Belajar, Ijin Belajar, Penggunaan Gelar, Ujian Dinas, Penyesuaian Ijazah',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        //upload file
        $file = $request->file('file')->store('arsip', 'public');

        Arsip::create([
            'pegawai_id' => $request->pegawai_id,
            'file' => $file,
            'jenis' => $request->jenis
        ]);

        return back()->with('success', 'Arsip Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Arsip $arsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arsip $arsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis' => 'required|in:SK CPNS,Surat Tugas,Surat Menghadap,Ijazah Pendidikan,Surat Nikah,KTP,NPWP, Kartu Keluarga, Akta Lahir Keluarga, Pas Photo, FIP, Konversi NIP, SK PNS,SK Kenaikan Pangkat, KPE, Karpeg, Taspen, Karis / Karsu, SK Mutasi BKN / Gubernur, ASKES / BPJS, STTPL, Sumpah Jabatan PNS, KGB, Rekomendasi Ijin Belajar, Ijin Belajar, Penggunaan Gelar, Ujian Dinas, Penyesuaian Ijazah',
            'file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($arsip->file && Storage::exists($arsip->file)) {
                Storage::delete($arsip->file);
            }

            // Simpan file baru
            $validatedData['file'] = $request->file('file')->store('arsip');
        }

        $arsip->update($validatedData);

        return back()->with('success', 'Arsip berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arsip $arsip)
    {
        if ( $arsip->file ) {
            Storage::delete($arsip->file);
        }
        // $arsip = Arsip::findOrFail($id);
        $arsip->delete();
        return back()->with('success', 'Arsip Berhasil Dihapus!');
    }
}
