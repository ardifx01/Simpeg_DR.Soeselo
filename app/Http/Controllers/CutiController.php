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
        // Load pegawai dengan relasi jabatan
        $pegawais = Pegawai::with('jabatan')->get();
        $atasans = Pegawai::with('jabatan')->get();
        return view('surat.cuti.create', compact('pegawais', 'atasans'));
    }

    /**
     * API endpoint untuk mengambil data pegawai
     */
    public function getPegawai($id)
    {
        try {
            $pegawai = Pegawai::with('jabatan')->findOrFail($id);
            
            return response()->json([
                'id' => $pegawai->id,
                'nama' => $pegawai->nama,
                'nip' => $pegawai->nip,
                'nama_jabatan' => $pegawai->jabatan ? $pegawai->jabatan->nama_jabatan : null,
                'unit_kerja' => $pegawai->jabatan ? $pegawai->jabatan->unit_kerja : null,
                'gelar_depan' => $pegawai->gelar_depan,
                'gelar_belakang' => $pegawai->gelar_belakang
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Pegawai tidak ditemukan'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'jenis_cuti' => 'required|string',
            'alasan' => 'required|string',
            'alasan_lainnya' => 'nullable|string|max:255',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat_cuti' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'atasan_id' => 'required|exists:pegawais,id',
        ]);
        
        $data = $request->except(['_token']);
        if ($request->alasan !== 'lainnya') {
            unset($data['alasan_lainnya']);
        }
        
        // Ambil data pegawai dengan relasi jabatan
        $pegawai = Pegawai::with('jabatan')->find($request->pegawai_id);
        if ($pegawai && $pegawai->jabatan) {
            $data['nama_jabatan'] = $pegawai->jabatan->nama_jabatan;
            $data['unit_kerja'] = $pegawai->jabatan->unit_kerja;
        }
        
        $atasanPegawai = Pegawai::with('jabatan')->find($request->atasan_id);
        if ($atasanPegawai) {
            $data['atasan_nama'] = $atasanPegawai->gelar_depan . '. ' . $atasanPegawai->nama . ', ' . $atasanPegawai->gelar_belakang;
            $data['atasan_nip'] = $atasanPegawai->nip;
            $data['atasan_jabatan'] = $atasanPegawai->jabatan?->nama_jabatan;
        }
        
        Cuti::create($data);

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
        $cuti->delete();
        return back()->with('success', 'Pengajuan cuti dipindahkan ke tong sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $cuti = Cuti::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('jenis_cuti', 'like', "%{$search}%")
                ->orWhere('alasan', 'like', "%{$search}%")
                ->orWhereHas('pegawai', fn($qp) =>
                    $qp->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%")
                );
            })
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('cuti.trash', compact('cuti', 'search'));
    }

    public function restore($id)
    {
        $cuti = Cuti::onlyTrashed()->findOrFail($id);
        $cuti->restore();
        return back()->with('success', 'Pengajuan cuti berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $cuti = Cuti::onlyTrashed()->findOrFail($id);
        $cuti->forceDelete();
        return back()->with('success', 'Pengajuan cuti dihapus permanen.');
    }

    public function export($id)
    {
        $cuti = Cuti::with('pegawai.jabatan')->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/cuti_template.docx'));

        $template->setValue('tanggal_surat', \Carbon\Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('nama', $cuti->pegawai->nama);
        $template->setValue('nip', $cuti->pegawai->nip ?? '-');
        $template->setValue('nama_jabatan', $cuti->pegawai->jabatan->nama_jabatan ?? '-');
        $template->setValue('unit_kerja', $cuti->pegawai->jabatan->unit_kerja ?? '-');
        $template->setValue('jenis_cuti', ucfirst($cuti->jenis_cuti));
        $template->setValue('alasan', $cuti->alasan === 'lainnya' ? $cuti->alasan_lainnya : $cuti->alasan);
        $template->setValue('lama_hari', $cuti->lama_hari);
        $template->setValue('tanggal_mulai', \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-m-Y'));
        $template->setValue('tanggal_selesai', \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d-m-Y'));
        $template->setValue('alamat_cuti', $cuti->alamat_cuti);
        $template->setValue('telepon', $cuti->telepon);
        $template->setValue('atasan_jabatan', $cuti->atasan_jabatan ?? '-');
        $template->setValue('atasan_nama', $cuti->atasan_nama ?? '-');
        $template->setValue('atasan_nip', $cuti->atasan_nip ?? '-');

        $filename = 'surat_cuti_' . str_replace(' ', '_', strtolower($cuti->pegawai->nama)) . '.docx';

        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
