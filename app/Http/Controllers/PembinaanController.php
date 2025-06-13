<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Pembinaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class PembinaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembinaan::query()->with('pegawai.jabatan');

        // Filter berdasarkan pegawai
        if ($request->has('pegawai_id') && $request->pegawai_id != 'all') {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan pembinaan
        if ($request->has('hubungan') && $request->hubungan != 'all') {
            $query->where('hubungan', $request->hubungan);
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
                ->orWhere('hubungan', 'like', "%$search%");
            });
        }

        $pembinaans = $query->latest()->paginate(10)->appends($request->query());
        return view('surat.pembinaan.index', compact('pembinaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.pembinaan.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'nama' => 'required',
            'pekerjaan' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'hubungan' => 'required|in:Suami,Istri',
        ]);

        pembinaan::create($request->all());

        return redirect()->route('pembinaan.index')->with('success', 'Pengajuan surat pembinaan berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembinaan $pembinaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembinaan $pembinaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembinaan $pembinaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembinaan $pembinaan)
    {
        //
    }

    public function export($id)
    {
        $pembinaan = Pembinaan::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/pembinaan_template.docx'));

        $template->setValue('hari_tanggal', Carbon::now()->translatedFormat('l, d F Y'));
        $template->setValue('nama_pegawai', $pembinaan->pegawai->nama);
        $template->setValue('nip', $pembinaan->pegawai->nip ?? '-');
        $template->setValue('pangkat', $pembinaan->pegawai->jabatan->nama ?? '-');
        $template->setValue('gologan_ruang', $pembinaan->pegawai->golongan_ruang ?? '-');
        $template->setValue('jabatan', $pembinaan->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('agama_pegawai', $pembinaan->pegawai->agama ?? '-');
        $template->setValue('alamat_pegawai', $pembinaan->pegawai->alamat ?? '-');
        $status = $pembinaan->pegawai->jabatan->jenis_kepegawaian ?? null;
        $statusFinal = in_array($status, ['PNS', 'PPPK', 'CPNS']) ? 'ASN' : ($status === 'BLUD' ? 'BLUD' : '-');
        $template->setValue('status', $statusFinal);
        $template->setValue('nama', $pembinaan->nama);
        $template->setValue('pekerjaan', $pembinaan->pekerjaan ?? '-');
        $template->setValue('agama', $pembinaan->agama ?? '-');
        $template->setValue('alamat', $pembinaan->alamat);
        $template->setValue('hubungan', ucfirst($pembinaan->hubungan));

        $filename = 'surat_pembinaan_' . str_replace(' ', '_', strtolower($pembinaan->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
