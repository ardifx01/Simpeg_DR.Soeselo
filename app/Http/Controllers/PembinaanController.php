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
        // Validasi data yang masuk dari request
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'atasan_id' => 'required|exists:pegawais,id',
            'nama_pasangan' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'hubungan' => 'required|in:Suami,Istri',
            'status_perceraian' => 'nullable|string|max:255',
        ]);

        // Mengambil semua data yang sudah divalidasi
        $data = $validatedData;

        // Ambil data atasan pegawai berdasarkan atasan_id yang dipilih
        $atasanPegawai = Pegawai::with('jabatan')->find($data['atasan_id']);

        if ($atasanPegawai) {
            // Mengisi kolom-kolom atasan dari data pegawai yang ditemukan
            $data['atasan_nama'] = $atasanPegawai->nama_lengkap;
            $data['atasan_nip'] = $atasanPegawai->nip;
            $data['atasan_jabatan'] = $atasanPegawai->jabatan?->nama_jabatan;
        }

        unset($data['atasan_id']);

        Pembinaan::create($data);

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
        $pembinaan->delete();
        return back()->with('success', 'Data pembinaan dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $pembinaans = Pembinaan::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('hubungan', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', fn ($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                    );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('pembinaan.trash', compact('pembinaans', 'search'));
    }

    public function restore($id)
    {
        $pembinaan = Pembinaan::onlyTrashed()->findOrFail($id);
        $pembinaan->restore();

        return back()->with('success', 'Data pembinaan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $pembinaan = Pembinaan::onlyTrashed()->findOrFail($id);
        $pembinaan->forceDelete();

        return back()->with('success', 'Data pembinaan dihapus permanen.');
    }

    public function export($id)
    {
        // Mencari data pembinaan beserta relasi pegawai dan jabatan terkait
        $pembinaan = Pembinaan::with('pegawai.jabatan', 'atasan.jabatan')->findOrFail($id);

        // Path ke template Word yang akan digunakan
        $template = new TemplateProcessor(storage_path('app/templates/pembinaan_template.docx'));

        // Mengisi data pada template Word
        $template->setValue('hari_tanggal', Carbon::now()->translatedFormat('l, d F Y'));
        $template->setValue('nama_pegawai', $pembinaan->pegawai->nama_lengkap);
        $template->setValue('nip_pegawai', $pembinaan->pegawai->nip ?? '-');
        $template->setValue('pangkat_pegawai', $pembinaan->pegawai->pangkat ?? '-');
        $template->setValue('golongan_ruang_pegawai', $pembinaan->pegawai->golongan_ruang ?? '-');
        $template->setValue('jabatan_pegawai', $pembinaan->pegawai->jabatan?->nama_jabatan ?? '-');
        $template->setValue('agama_pegawai', $pembinaan->pegawai->agama ?? '-');
        $template->setValue('alamat_pegawai', $pembinaan->pegawai->alamat_lengkap ?? '-');
        $status = $pembinaan->pegawai->jabatan?->jenis_kepegawaian ?? null;
        $statusFinal = in_array($status, ['PNS', 'PPPK', 'CPNS']) ? 'ASN' : ($status === 'BLUD' ? 'BLUD' : '-');
        $template->setValue('status_kepegawaian', $statusFinal);
        $template->setValue('nama_pasangan', $pembinaan->nama_pasangan);
        $template->setValue('pekerjaan', $pembinaan->pekerjaan ?? '-');
        $template->setValue('agama_pasangan', $pembinaan->agama ?? '-');
        $template->setValue('alamat_pasangan', $pembinaan->alamat);
        $template->setValue('hubungan', ucfirst($pembinaan->hubungan));
        $template->setValue('status_perceraian', $pembinaan->status_perceraian ?? '-');
        $template->setValue('nama_atasan', $pembinaan->atasan?->nama_lengkap ?? '-');
        $template->setValue('nip_atasan', $pembinaan->atasan?->nip ?? '-');
        $template->setValue('jabatan_atasan', $pembinaan->atasan?->jabatan?->nama_jabatan ?? '-');

        // Menyimpan file dan mengunduhnya
        $filename = 'surat_pembinaan_' . str_replace(' ', '_', strtolower($pembinaan->pegawai->nama)) . '.docx';
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
