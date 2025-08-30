<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KeteranganRawat;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class KeteranganRawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KeteranganRawat::query()->with('pegawai.jabatan');

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

        $keteranganRawats = $query->latest()->paginate(10)->appends($request->query());
        return view('surat.rawat.index', compact('keteranganRawats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('surat.rawat.create', compact('pegawais'));
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

        KeteranganRawat::create($request->all());

        return redirect()->route('rawat.index')->with('success', 'Pengajuan surat keterangan rawat berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KeteranganRawat $keteranganRawat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeteranganRawat $keteranganRawat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeteranganRawat $keteranganRawat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeteranganRawat $keteranganRawat)
    {
        $keteranganRawat->delete();
        return back()->with('success', 'Keterangan rawat dipindahkan ke tong sampah.');
    }
    public function trash(Request $request)
    {
        $search = $request->input('search');

        $keteranganRawats = KeteranganRawat::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('jenis_keterangan', 'like', "%{$search}%")
                    ->orWhere('alasan', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('rawat.trash', compact('keteranganRawats', 'search'));
    }

    public function restore($id)
    {
        $keteranganRawat = KeteranganRawat::onlyTrashed()->findOrFail($id);
        $keteranganRawat->restore();

        return back()->with('success', 'Keterangan rawat berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $keteranganRawat = KeteranganRawat::onlyTrashed()->findOrFail($id);
        $keteranganRawat->forceDelete();

        return back()->with('success', 'Keterangan rawat dihapus permanen.');
    }

    public function export($id)
    {
        $keteranganRawat = KeteranganRawat::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/keteranganRawat_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama_pegawai', $keteranganRawat->pegawai->nama);
        $template->setValue('nip', $keteranganRawat->pegawai->nip ?? '-');
        $template->setValue('tempat_lahir_pegawai', $keteranganRawat->pegawai->tempat_lahir ?? '-');
        $template->setValue('tanggal_lahir_pegawai', \Carbon\Carbon::parse($keteranganRawat->pegawai->tanggal_lahir)->format('d-m-Y'));
        $template->setValue('jabatan', $keteranganRawat->pegawai->jabatan->nama_jabatan ?? '-');
        $template->setValue('pendidikan', $keteranganRawat->pegawai->pendidikan->tingkat ?? '-');
        $template->setValue('alamat_pegawai', $keteranganRawat->pegawai->alamat ?? '-');
        $template->setValue('unit_kerja', $keteranganRawat->pegawai->jabatan->unit_kerja ?? '-');
        $status = $keteranganRawat->pegawai->jabatan->jenis_kepegawaian ?? null;
        $statusFinal = in_array($status, ['PNS', 'PPPK', 'CPNS']) ? 'ASN' : ($status === 'BLUD' ? 'BLUD' : '-');
        $template->setValue('status', $statusFinal);
        $template->setValue('status_rawat', $keteranganRawat->status_rawat);
        $template->setValue('nama', $keteranganRawat->nama);
        $template->setValue('nik', $keteranganRawat->nik ?? '-');
        $template->setValue('tempat_lahir', $keteranganRawat->tempat_lahir ?? '-');
        $template->setValue('tanggal_lahir', \Carbon\Carbon::parse($keteranganRawat->tanggal_lahir)->format('d-m-Y'));
        $template->setValue('agama', $keteranganRawat->agama ?? '-');
        $template->setValue('alamat', $keteranganRawat->alamat);
        $template->setValue('pekerjaan', $keteranganRawat->pekerjaan);
        $template->setValue('hubungan', ucfirst($keteranganRawat->hubungan));

        $filename = 'surat_keterangan_rawat_' . str_replace(' ', '_', strtolower($keteranganRawat->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
