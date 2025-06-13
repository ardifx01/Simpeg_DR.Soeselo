<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cuti::query()->with('pegawai.jabatan');

        // Filter berdasarkan pegawai
        if ($request->has('pegawai_id') && $request->pegawai_id != 'all') {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan jenis cuti
        if ($request->has('jenis_cuti') && $request->jenis_cuti != 'all') {
            $query->where('jenis_cuti', $request->jenis_cuti);
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
                // Atau di jenis_cuti
                ->orWhere('jenis_cuti', 'like', "%$search%");
            });
        }

        $cutis = $query->latest()->paginate(10)->appends($request->query());
        return view('surat.cuti.index', compact('cutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.cuti.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis_cuti' => 'required',
            'alasan' => 'required',
            'alasan_lainnya' => 'nullable',
            'lama_hari' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat_cuti' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
        ]);

        Cuti::create($request->all());

        return redirect()->route('cuti.index')->with('success', 'Pengajuan surat cuti berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuti $cuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuti $cuti)
    {
        //
    }

    public function export($id)
    {
        $cuti = Cuti::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/cuti_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama', $cuti->pegawai->nama);
        $template->setValue('nip', $cuti->pegawai->nip ?? '-');
        $template->setValue('jabatan', $cuti->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('unit_kerja', $cuti->pegawai->jabatan->skpd ?? '-');
        $template->setValue('jenis_cuti', ucfirst($cuti->jenis_cuti));
        $template->setValue('alasan', $cuti->alasan);
        $template->setValue('alasan_lainnya', $cuti->alasan_lainnya);
        $template->setValue('lama_hari', $cuti->lama_hari);
        $template->setValue('tanggal_mulai', \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-m-Y'));
        $template->setValue('tanggal_selesai', \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-m-Y'));
        $template->setValue('alamat_cuti', $cuti->alamat_cuti);
        $template->setValue('telepon', $cuti->telepon);

        $filename = 'surat_cuti_' . str_replace(' ', '_', strtolower($cuti->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

}
