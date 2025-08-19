<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Biarkan query builder tetap aktif
        $query = BeritaAcara::with(['pihakPertama', 'pihakKedua', 'atasan']);

        // Filter berdasarkan pihak pertama
        if ($request->filled('pihak_pertama_id') && $request->pihak_pertama_id != 'all') {
            $query->where('pihak_pertama_id', $request->pihak_pertama_id);
        }

        // Filter berdasarkan pihak kedua
        if ($request->filled('pihak_kedua_id') && $request->pihak_kedua_id != 'all') {
            $query->where('pihak_kedua_id', $request->pihak_kedua_id);
        }

        // Filter berdasarkan atasan
        if ($request->filled('atasan_id') && $request->atasan_id != 'all') {
            $query->where('atasan_id', $request->atasan_id);
        }

        // Pencarian dengan relasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%$search%")
                ->orWhereHas('pihakPertama', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                })
                ->orWhereHas('pihakKedua', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                })
                ->orWhereHas('atasan', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                });
            });
        }

        // Eksekusi kueri hanya di akhir
        $beritaAcaras = $query->latest()->paginate(10)->appends($request->query());

        return view('surat.berita_acara.index', compact('beritaAcaras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data pegawai dalam satu kali kueri
        $pegawais = Pegawai::with('jabatan')->get();
        
        // Kirim variabel 'pegawais' ke view
        return view('surat.berita_acara.create', compact('pegawais'));
    }

    /**
     * API endpoint untuk mengambil data pegawai
     */
    public function getPegawai(Request $request)
    {
        try {
            $pegawai = Pegawai::with('jabatan')->findOrFail($request->id);
            
            return response()->json([
                'id' => $pegawai->id,
                'nama' => $pegawai->nama,
                'nip' => $pegawai->nip,
                'alamat' => $pegawai->alamat,
                'jabatan' => $pegawai->jabatan ? $pegawai->jabatan->nama_jabatan : null,
                'pangkat' => $pegawai->pangkat,
                'golongan' => $pegawai->golongan
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
        $validatedData = $request->validate([
            'nomor' => 'required|string|max:255',
            'hari' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'pihak_pertama_id' => 'required|exists:pegawais,id',
            'pihak_kedua_id' => 'nullable|exists:pegawais,id',
            'atasan_id' => 'nullable|exists:pegawais,id',
        ]);

        // Konversi tanggal dari dd-mm-yyyy ke YYYY-MM-DD sebelum disimpan
        if (!empty($validatedData['tanggal'])) {
            $validatedData['tanggal'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal'])->format('Y-m-d');
        }

        // Simpan berita acara
        BeritaAcara::create($validatedData);

        return redirect()->route('berita_acara.index')->with('success', 'Pengajuan Berita Acara Berhasil.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BeritaAcara $beritaAcara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeritaAcara $beritaAcara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeritaAcara $beritaAcara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeritaAcara $beritaAcara)
    {
        $beritaAcara->delete();
        return redirect()->route('berita_acara.index')->with('success', 'Berita Acara Berhasil Dihapus.');
    }

    public function export($id)
    {
        $beritaAcara = BeritaAcara::with(['pihakPertama', 'pihakKedua', 'atasan'])->findOrFail($id);

        $template = new TemplateProcessor(storage_path('app/templates/beritaAcara_template.docx'));
        
        $template->setValue('nomor', $beritaAcara->nomor);
        $template->setValue('hari', $beritaAcara->hari);
        $template->setValue('tanggal', \Carbon\Carbon::parse($beritaAcara->tanggal)->translatedFormat('d F Y'));

        $template->setValue('nama_pihak_pertama', optional($beritaAcara->pihakPertama)->nama_lengkap ?? '-');
        $template->setValue('nip_pihak_pertama', optional($beritaAcara->pihakPertama)->nip ?? '-');
        $template->setValue('pangkat_pihak_pertama', optional($beritaAcara->pihakPertama)->pangkat_golongan ?? '-');
        $template->setValue('jabatan_pihak_pertama', optional(optional($beritaAcara->pihakPertama)->jabatan)->nama_jabatan ?? '-');
        $template->setValue('alamat_pihak_pertama', optional($beritaAcara->pihakPertama)->alamat_lengkap ?? '-');

        if ($beritaAcara->pihakKedua) {
            $template->setValue('nama_pihak_kedua', $beritaAcara->pihakKedua->nama_lengkap ?? '-');
            $template->setValue('nip_pihak_kedua', $beritaAcara->pihakKedua->nip ?? '-');
            $template->setValue('pangkat_pihak_kedua', $beritaAcara->pihakKedua->pangkat_golongan ?? '-');
            $template->setValue('jabatan_pihak_kedua', optional($beritaAcara->pihakKedua->jabatan)->nama_jabatan ?? '-');
            $template->setValue('alamat_pihak_kedua', $beritaAcara->pihakKedua->alamat_lengkap ?? '-');
        } else {
            $template->setValue('nama_pihak_kedua', '-');
            $template->setValue('nip_pihak_kedua', '-');
            $template->setValue('pangkat_pihak_kedua', '-');
            $template->setValue('jabatan_pihak_kedua', '-');
            $template->setValue('alamat_pihak_kedua', '-');
        }
        $template->setValue('nama_atasan', optional($beritaAcara->atasan)->nama_lengkap ?? '-');
        $template->setValue('nip_atasan', optional($beritaAcara->atasan)->nip ?? '-');
        $template->setValue('jabatan_atasan', data_get($beritaAcara->atasan, 'jabatan.nama_jabatan', '-'));
        $template->setValue('pangkat_atasan', optional($beritaAcara->atasan)->pangkat_golongan ?? '-');

        $namaPegawai = data_get($beritaAcara, 'pihakPertama.nama', 'pegawai_tidak_ada');
        $filename = 'surat_berita_acara_' . str_replace(' ', '_', strtolower($namaPegawai)) . '.docx';
        
        $path = storage_path("app/public/{$filename}");
        $template->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}

