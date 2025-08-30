<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\SkpHeader;
use App\Models\SkpKegiatan;
use App\Models\SkpTambahan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\SkpCatatanPenilaian;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SkpHeader::with(['pegawaiDinilai', 'pegawaiPenilai', 'atasanPegawaiPenilai']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tahun', 'like', "%$search%")
                ->orWhereHas('pegawaiDinilai', function ($pegawai) use ($search) {
                    $pegawai->where('nama_lengkap', 'like', "%$search%")
                            ->orWhere('nip', 'like', "%$search%");
                });
            });
        }
        
        $skpHeaders = $query->latest()->paginate(10)->appends($request->query());
        
        return view('surat.skp.index', compact('skpHeaders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data pegawai untuk dropdown (pegawai yang dinilai, penilai, atasan)
        $pegawais = Pegawai::all();

        return view('surat.skp.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'pegawai_dinilai_id' => 'required|exists:pegawais,id',
            'pegawai_penilai_id' => 'required|exists:pegawais,id',
            'atasan_pegawai_penilai_id' => 'required|exists:pegawais,id',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 5),

            // Validasi aspek perilaku individual
            'orientasi_pelayanan' => 'required|numeric|min:0|max:100',
            'integritas' => 'required|numeric|min:0|max:100',
            'komitmen' => 'required|numeric|min:0|max:100',
            'disiplin' => 'required|numeric|min:0|max:100',
            'kerjasama' => 'required|numeric|min:0|max:100',
            'kepemimpinan' => 'nullable|numeric|min:0|max:100',
            'nilai_perilaku' => 'required|numeric|min:0|max:100',
            
            // Validasi untuk kegiatan
            'kegiatan' => 'required|array|min:1',
            'kegiatan.*.jenis_kegiatan' => 'required|string|max:255',
            'kegiatan.*.nama_kegiatan' => 'required|string|max:255',
            'kegiatan.*.ak' => 'nullable|string|max:255',
            'kegiatan.*.target_kuantitatif_output' => 'required|string|max:255',
            'kegiatan.*.realisasi_kuantitatif_output' => 'nullable|string|max:255',
            'kegiatan.*.target_kualitatif_mutu' => 'required|numeric|min:0',
            'kegiatan.*.realisasi_kualitatif_mutu' => 'nullable|numeric|min:0',
            'kegiatan.*.target_waktu_bulan' => 'required|integer|min:1',
            'kegiatan.*.realisasi_waktu_bulan' => 'nullable|integer|min:0',
            'kegiatan.*.target_biaya' => 'nullable|numeric|min:0',
            'kegiatan.*.realisasi_biaya' => 'nullable|numeric|min:0',

            // Validasi tugas tambahan
            'tugas_tambahan' => 'nullable|array',
            'tugas_tambahan.*.nama_tambahan' => 'nullable|string',
            'tugas_tambahan.*.nilai_tambahan' => 'nullable|numeric',
            
            // Validasi untuk catatan penilaian
            'catatan_tanggal' => 'nullable|date_format:d-m-Y',
            'uraian' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
        // Menghitung nilai capaian SKP per kegiatan dulu
        $totalCapaianKegiatan = 0;
        $jumlahKegiatan = count($request->kegiatan ?? []);

        if ($jumlahKegiatan > 0) {
            foreach ($request->kegiatan as $kegiatanData) {
                // Hitung nilai total kegiatan (jumlah 4 aspek)
                $nilaiTotalKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                
                // Hitung capaian per kegiatan (rata-rata dari 4 aspek)
                $capaianPerKegiatan = $nilaiTotalKegiatan / 4;
                
                // Jumlahkan capaian semua kegiatan
                $totalCapaianKegiatan += $capaianPerKegiatan;
            }
            
            // Hitung rata-rata capaian dari semua kegiatan
            $nilaiCapaianSkp = $totalCapaianKegiatan / $jumlahKegiatan;
        } else {
            $nilaiCapaianSkp = 0;
        }

        // Hitung total nilai tambahan
        $totalNilaiTambahan = 0;
        if (!empty($request->tugas_tambahan)) {
            foreach ($request->tugas_tambahan as $tugas) {
                $totalNilaiTambahan += floatval($tugas['nilai_tambahan'] ?? 0);
            }
        }

        // Tambahkan total nilai tambahan ke nilai capaian SKP
        $nilaiCapaianSkp += $totalNilaiTambahan;

        // Hitung nilai akhir (60% Capaian SKP + 40% Perilaku)
        $nilaiAkhir = ($nilaiCapaianSkp * 0.6) + ($request->nilai_perilaku * 0.4);
        
        // Tentukan kategori
        $kategori = $this->getKategori($nilaiAkhir);

        // Simpan SKP Header
        $skpHeader = SkpHeader::create([
            'pegawai_dinilai_id' => $request->pegawai_dinilai_id,
            'pegawai_penilai_id' => $request->pegawai_penilai_id,
            'atasan_pegawai_penilai_id' => $request->atasan_pegawai_penilai_id,
            'tahun' => $request->tahun,
            'nilai_capaian_skp' => $nilaiCapaianSkp,
            'nilai_perilaku' => $request->nilai_perilaku,
            'nilai_akhir' => $nilaiAkhir,
            'kategori' => $kategori,
        ]);

        // Simpan kegiatan-kegiatan
        if ($request->has('kegiatan')) {
            foreach ($request->kegiatan as $kegiatanData) {
                $nilaiKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                
                SkpKegiatan::create([
                    'skp_header_id' => $skpHeader->id,
                    'jenis_kegiatan' => $kegiatanData['jenis_kegiatan'],
                    'nama_kegiatan' => $kegiatanData['nama_kegiatan'],
                    'ak' => $kegiatanData['ak'] ?? null,
                    'target_kuantitatif_output' => $kegiatanData['target_kuantitatif_output'],
                    'realisasi_kuantitatif_output' => $kegiatanData['realisasi_kuantitatif_output'] ?? null,
                    'target_kualitatif_mutu' => $kegiatanData['target_kualitatif_mutu'],
                    'realisasi_kualitatif_mutu' => $kegiatanData['realisasi_kualitatif_mutu'] ?? null,
                    'target_waktu_bulan' => $kegiatanData['target_waktu_bulan'],
                    'realisasi_waktu_bulan' => $kegiatanData['realisasi_waktu_bulan'] ?? null,
                    'target_biaya' => $kegiatanData['target_biaya'] ?? null,
                    'realisasi_biaya' => $kegiatanData['realisasi_biaya'] ?? null,
                    'nilai_kegiatan' => number_format($nilaiKegiatan, 2), // Format 2 decimal places
                ]);
            }
        }

            // Simpan tugas tambahan jika ada dan valid
            if ($request->filled('tugas_tambahan')) {
                foreach ($request->input('tugas_tambahan') as $tugas) {
                    if (empty($tugas['nama_tambahan'])) continue;

                    $skpHeader->tugasTambahan()->create([
                        'nama_tambahan' => $tugas['nama_tambahan'],
                        'nilai_tambahan' => $tugas['nilai_tambahan'] ?? null,
                    ]);
                }
            }

            // Ambil data pegawai penilai dari database
            $pegawaiPenilai = Pegawai::find($request->pegawai_penilai_id);
            $namaPenilai = $pegawaiPenilai ? $pegawaiPenilai->nama_lengkap : '';
            $nipPenilai = $pegawaiPenilai ? $pegawaiPenilai->nip : '';

            // Format uraian perilaku menggunakan method yang sudah dibuat
            $uraianPerilaku = $this->formatUraianPerilaku($request->all());

            // Simpan catatan penilaian
            if ($request->has('catatan_tanggal')) {
                $catatanTanggal = $request->input('catatan_tanggal');

                if (!empty($catatanTanggal)) {
                    $tanggal = Carbon::createFromFormat('d-m-Y', $catatanTanggal)->format('Y-m-d');
                    
                    SkpCatatanPenilaian::create([
                        'skp_header_id' => $skpHeader->id,
                        'tanggal' => $tanggal,
                        'uraian' => $uraianPerilaku,
                        'nama_pegawai_penilai' => $namaPenilai,
                        'nip_pegawai_penilai' => $nipPenilai,
                    ]);
                }
            }
        });

        return redirect()->route('skp.index')->with('success', 'SKP berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkpHeader $skp)
    {
        $skp->load(['pegawaiDinilai', 'pegawaiPenilai', 'atasanPegawaiPenilai', 'kegiatan', 'tugasTambahan', 'catatanPenilaian']);

        if ($skp->catatanPenilaian && $skp->catatanPenilaian->uraian) {
            $uraianText = $skp->catatanPenilaian->uraian;

            $pattern = '/(Orientasi Pelayanan|Integritas|Komitmen|Disiplin|Kerjasama|Kepemimpinan)\s*:\s*([^-\s]+)/';

            preg_match_all($pattern, $uraianText, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $label = str_replace(' ', '_', strtolower($match[1]));
                $value = trim($match[2]);
                
                // convert ke float biar bisa dibandingin
                $nilai = is_numeric($value) ? (float)$value : null;

                // simpen nilai dan kategorinya
                $parsedPerilaku[$label] = [
                    'nilai' => $nilai,
                    'kategori' => $this->getKategori($nilai),
                ];
            }
        }

        $formattedUraian = $parsedPerilaku; 
        return view('surat.skp.show', compact('skp', 'formattedUraian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkpHeader $skp)
    {
        $skp->load(['kegiatan', 'catatanPenilaian']);

        $kegiatanTugasJabatan = $skp->kegiatan->where('jenis_kegiatan', 'tugas_jabatan');
        $kegiatanTugasTambahan = $skp->kegiatan->where('jenis_kegiatan', 'tugas_tambahan');

        $pegawais = Pegawai::all();

        return view('surat.skp.edit', compact(
            'skp', 
            'pegawais', 
            'kegiatanTugasJabatan', 
            'kegiatanTugasTambahan'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkpHeader $skp)
    {
        $request->validate([
            'pegawai_dinilai_id' => 'required|exists:pegawais,id',
            'pegawai_penilai_id' => 'required|exists:pegawais,id',
            'atasan_pegawai_penilai_id' => 'required|exists:pegawais,id',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 5),
            'nilai_perilaku' => 'required|numeric|min:0|max:100',
            
            // Validasi kegiatan
            'kegiatan.*.jenis_kegiatan' => 'required|string|max:255',
            'kegiatan.*.nama_kegiatan' => 'required|string|max:255',
            'kegiatan.*.ak' => 'nullable|string|max:255',
            'kegiatan.*.target_kuantitatif_output' => 'required|string|max:255',
            'kegiatan.*.realisasi_kuantitatif_output' => 'nullable|string|max:255',
            'kegiatan.*.target_kualitatif_mutu' => 'required|numeric|min:0',
            'kegiatan.*.realisasi_kualitatif_mutu' => 'nullable|numeric|min:0',
            'kegiatan.*.target_waktu_bulan' => 'required|integer|min:1',
            'kegiatan.*.realisasi_waktu_bulan' => 'nullable|integer|min:0',
            'kegiatan.*.target_biaya' => 'nullable|numeric|min:0',
            'kegiatan.*.realisasi_biaya' => 'nullable|numeric|min:0',

            // Validasi tugas tambahan
            'tugas_tambahan' => 'nullable|array',
            'tugas_tambahan.*.nama_tambahan' => 'nullable|string',
            'tugas_tambahan.*.nilai_tambahan' => 'nullable|string',

            // Validasi catatan oenilaian
            'catatan_tanggal' => 'nullable|date_format:d-m-Y',
            'uraian' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $skp) {
        // Hapus data lama
        $skp->kegiatan()->delete();
        $skp->tugasTambahan()->delete();
        $skp->catatanPenilaian()->delete();

        // Hitung nilai capaian SKP dari kegiatan
        $totalCapaianKegiatan = 0;
        $jumlahKegiatan = count($request->kegiatan ?? []);

        if ($jumlahKegiatan > 0) {
            foreach ($request->kegiatan as $kegiatanData) {
                // Hitung nilai total kegiatan (jumlah 4 aspek)
                $nilaiTotalKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                
                // Hitung capaian per kegiatan (rata-rata dari 4 aspek)
                $capaianPerKegiatan = $nilaiTotalKegiatan / 4;
                
                // Jumlahkan capaian semua kegiatan
                $totalCapaianKegiatan += $capaianPerKegiatan;
            }
            
            // Hitung rata-rata capaian dari semua kegiatan
            $nilaiCapaianSkp = $totalCapaianKegiatan / $jumlahKegiatan;
        } else {
            $nilaiCapaianSkp = 0;
        }

        // Hitung total nilai tambahan
        $totalNilaiTambahan = 0;
        if (!empty($request->tugas_tambahan)) {
            foreach ($request->tugas_tambahan as $tugas) {
                $totalNilaiTambahan += floatval($tugas['nilai_tambahan'] ?? 0);
            }
        }

        // Gabungkan nilai tambahan ke nilai capaian SKP
        $nilaiCapaianSkp += $totalNilaiTambahan;

        // Nilai akhir = 60% SKP + 40% perilaku
        $nilaiAkhir = ($nilaiCapaianSkp * 0.6) + ($request->nilai_perilaku * 0.4);

        // Kategori
        $kategori = $this->getKategori($nilaiAkhir);

        // Update SKP Header
        $skp->update([
            'pegawai_dinilai_id' => $request->pegawai_dinilai_id,
            'pegawai_penilai_id' => $request->pegawai_penilai_id,
            'atasan_pegawai_penilai_id' => $request->atasan_pegawai_penilai_id,
            'tahun' => $request->tahun,
            'nilai_capaian_skp' => $nilaiCapaianSkp,
            'nilai_perilaku' => $request->nilai_perilaku,
            'nilai_akhir' => $nilaiAkhir,
            'kategori' => $kategori,
        ]);

        // Simpan kegiatan baru
        if ($request->has('kegiatan')) {
            foreach ($request->kegiatan as $kegiatanData) {
                $nilaiKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                $skp->kegiatan()->create([
                    'jenis_kegiatan' => $kegiatanData['jenis_kegiatan'],
                    'nama_kegiatan' => $kegiatanData['nama_kegiatan'],
                    'ak' => $kegiatanData['ak'] ?? null,
                    'target_kuantitatif_output' => $kegiatanData['target_kuantitatif_output'],
                    'realisasi_kuantitatif_output' => $kegiatanData['realisasi_kuantitatif_output'] ?? null,
                    'target_kualitatif_mutu' => $kegiatanData['target_kualitatif_mutu'],
                    'realisasi_kualitatif_mutu' => $kegiatanData['realisasi_kualitatif_mutu'] ?? null,
                    'target_waktu_bulan' => $kegiatanData['target_waktu_bulan'],
                    'realisasi_waktu_bulan' => $kegiatanData['realisasi_waktu_bulan'] ?? null,
                    'target_biaya' => $kegiatanData['target_biaya'] ?? null,
                    'realisasi_biaya' => $kegiatanData['realisasi_biaya'] ?? null,
                    'nilai_kegiatan' => number_format($nilaiKegiatan, 2), // Format 2 decimal places
                ]);
            }
        }

        // Simpan tugas tambahan jika ada dan valid
        if ($request->filled('tugas_tambahan')) {
            foreach ($request->input('tugas_tambahan') as $tugas) {
                if (empty($tugas['nama_tambahan'])) continue;

                $skp->tugasTambahan()->create([
                    'nama_tambahan' => $tugas['nama_tambahan'],
                    'nilai_tambahan' => $tugas['nilai_tambahan'] ?? null,
                ]);
            }
        }

        // Ambil data pegawai penilai dari database
        $pegawaiPenilai = Pegawai::find($request->pegawai_penilai_id);
        $namaPenilai = $pegawaiPenilai ? $pegawaiPenilai->nama_lengkap : '';
        $nipPenilai = $pegawaiPenilai ? $pegawaiPenilai->nip : '';

        // Format uraian perilaku menggunakan method yang sudah dibuat
        $uraianPerilaku = $this->formatUraianPerilaku($request->all());

        // Simpan catatan penilaian
        if ($request->has('catatan_tanggal')) {
            $catatanTanggal = $request->input('catatan_tanggal');

            if (!empty($catatanTanggal)) {
                $tanggal = Carbon::createFromFormat('d-m-Y', $catatanTanggal)->format('Y-m-d');
                
                $skp->catatanPenilaian()->create([
                    'tanggal' => $tanggal,
                    'uraian' => $uraianPerilaku,
                    'nama_pegawai_penilai' => $namaPenilai,
                    'nip_pegawai_penilai' => $nipPenilai,
                ]);
            }
        }
    });

        return redirect()->route('skp.index')->with('success', 'SKP berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkpHeader $skp)
    {
        try {
            DB::transaction(function () use ($skp) {
                // Soft delete anak-anak dulu biar konsisten
                SkpKegiatan::where('skp_header_id', $skp->id)->delete();
                SkpTambahan::where('skp_header_id', $skp->id)->delete();
                SkpCatatanPenilaian::where('skp_header_id', $skp->id)->delete();

                // Terus soft delete header
                $skp->delete();
            });

            return redirect()->route('skp.index')->with('success', 'SKP berhasil dipindahkan ke tong sampah!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus SKP: ' . $e->getMessage());
        }
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');

        $skpHeaders = SkpHeader::onlyTrashed()
            ->when($search, function ($q) use ($search) {
                $q->where('tahun', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhereHas('pegawaiDinilai', fn($qp) =>
                            $qp->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%"))
                    ->orWhereHas('pegawaiPenilai', fn($qr) =>
                            $qr->where('nama', 'like', "%{$search}%")
                            ->orWhere('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%"));
            })
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('skp.trash', compact('skpHeaders', 'search'));
    }

    public function restore($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $skp = SkpHeader::onlyTrashed()->findOrFail($id);

                // Restore header dulu
                $skp->restore();

                // Lalu restore semua child yang terkait
                SkpKegiatan::onlyTrashed()->where('skp_header_id', $skp->id)->restore();
                SkpTambahan::onlyTrashed()->where('skp_header_id', $skp->id)->restore();
                SkpCatatanPenilaian::onlyTrashed()->where('skp_header_id', $skp->id)->restore();
            });

            return back()->with('success', 'SKP beserta detailnya berhasil dipulihkan.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memulihkan SKP: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $skp = SkpHeader::onlyTrashed()->findOrFail($id);

                // Force delete semua child dulu
                SkpKegiatan::withTrashed()->where('skp_header_id', $skp->id)->forceDelete();
                SkpTambahan::withTrashed()->where('skp_header_id', $skp->id)->forceDelete();
                SkpCatatanPenilaian::withTrashed()->where('skp_header_id', $skp->id)->forceDelete();

                // Terakhir force delete header
                $skp->forceDelete();
            });

            return back()->with('success', 'SKP beserta detailnya dihapus permanen.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus permanen SKP: ' . $e->getMessage());
        }
    }

    /**
     * Mencetak SKP ke format PDF.
     */
    public function cetakPdf(SkpHeader $skp)
    {
        $skp->load([
            'pegawaiDinilai.jabatan',
            'pegawaiPenilai.jabatan',
            'atasanPegawaiPenilai.jabatan',
            'kegiatan',
            'catatanPenilaian'
        ]);

        $kegiatanDokumen  = $skp->kegiatan->where('jenis_kegiatan', 'Dokumen');
        $kegiatanKegiatan = $skp->kegiatan->where('jenis_kegiatan', 'Kegiatan');
        $kegiatanLapangan = $skp->kegiatan->where('jenis_kegiatan', 'Lapangan');
        $allKegiatan      = $skp->kegiatan;

        // === PARSE PERILAKU DARI URAIAN (+ fallback model) ===
        $perilaku = [];

        if ($skp->catatanPenilaian && $skp->catatanPenilaian->uraian) {
            $uraianText = $skp->catatanPenilaian->uraian;
            $pattern = '/(Orientasi Pelayanan|Integritas|Komitmen|Disiplin|Kerjasama|Kepemimpinan)\s*:\s*([0-9]+(?:[.,][0-9]+)?)/i';
            preg_match_all($pattern, $uraianText, $matches, PREG_SET_ORDER);

            foreach ($matches as $m) {
                $key = str_replace(' ', '_', strtolower($m[1]));
                $num = (float) str_replace(',', '.', trim($m[2]));
                $perilaku[$key] = [
                    'nilai'    => $num,
                    'kategori' => $this->getKategori($num),
                ];
            }
        }

        $mapModel = [
            'orientasi_pelayanan' => $skp->nilai_perilaku_orientasi_pelayanan ?? null,
            'integritas'          => $skp->nilai_perilaku_integritas ?? null,
            'komitmen'            => $skp->nilai_perilaku_komitmen ?? null,
            'disiplin'            => $skp->nilai_perilaku_disiplin ?? null,
            'kerjasama'           => $skp->nilai_perilaku_kerjasama ?? null,
            'kepemimpinan'        => $skp->nilai_perilaku_kepemimpinan ?? null,
        ];
        foreach ($mapModel as $k => $v) {
            if (!isset($perilaku[$k]) && $v !== null) {
                $num = (float) $v;
                $perilaku[$k] = [
                    'nilai'    => $num,
                    'kategori' => $this->getKategori($num),
                ];
            }
        }

        // bentuk string siap cetak (nilai — kategori)
        $formattedUraian = $this->formatUraianPerilaku($perilaku);

        $pdf = Pdf::loadView('surat.skp.cetak.pdf', compact(
            'skp',
            'kegiatanDokumen',
            'kegiatanKegiatan',
            'kegiatanLapangan',
            'allKegiatan',
            'formattedUraian'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'defaultFont'    => 'sans-serif',
            'isRemoteEnabled'=> true,
        ]);

        $filename = 'SKP-' . $skp->pegawaiDinilai->nip . '-' . $skp->tahun . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Mencetak SKP ke format Word.
     */
    public function cetakWord(SkpHeader $skp)
    {
        try {
            $skp->load([
                'pegawaiDinilai.jabatan',
                'pegawaiPenilai.jabatan',
                'atasanPegawaiPenilai.jabatan',
                'kegiatan',
                'tugasTambahan',
                'catatanPenilaian'
            ]);

            $templatePath = storage_path('app/templates/skp_template.docx');
            if (!file_exists($templatePath)) {
                return redirect()->back()->with('error', 'Template Word tidak ditemukan!');
            }

            $template = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

            $pegawaiDinilai = $skp->pegawaiDinilai;
            $pegawaiPenilai = $skp->pegawaiPenilai;
            $atasanPenilai  = $skp->atasanPegawaiPenilai;
            $catatan        = $skp->catatanPenilaian;

            // === HITUNG NILAI CAPAIAN SKP ala store() ===

            // 1) Kumpulin capaian per kegiatan
            $capaianList = [];

            // Jika di DB sudah ada kolom 'nilai_capaian' per kegiatan
            foreach ($skp->kegiatan as $k) {
                $v = $k->nilai_capaian ?? null;
                // normalisasi koma -> titik
                if (is_string($v)) $v = str_replace(',', '.', $v);
                if (is_numeric($v)) $capaianList[] = (float)$v;
            }

            // Jika kolom di atas kosong hitung manual dari 4 komponen
            if (count($capaianList) === 0) {
                foreach ($skp->kegiatan as $k) {
                    $total4 = $this->calculateNilaiKegiatan($k->toArray());
                    if (is_numeric($total4)) {
                        $capaianList[] = ((float)$total4) / 4.0;
                    }
                }
            }

            $jumlahKegiatan = count($capaianList);
            $rataKegiatan   = $jumlahKegiatan > 0 ? array_sum($capaianList) / $jumlahKegiatan : 0.0;

            // 2) Total nilai tambahan (tanpa rata-rata)
            $totalNilaiTambahan = 0.0;
            foreach ($skp->tugasTambahan as $t) {
                $v = $t->nilai_tambahan ?? null;
                if (is_string($v)) $v = str_replace(',', '.', $v);
                if (is_numeric($v)) $totalNilaiTambahan += (float)$v;
            }

            // 3) Nilai Capaian SKP = rata-rata kegiatan + total tambahan
            $nilaiCapaianSkp = $rataKegiatan + $totalNilaiTambahan;

            // 4) Perilaku & nilai akhir
            $nilaiPerilaku     = is_numeric($skp->nilai_perilaku) ? (float)$skp->nilai_perilaku : 0.0;
            $nilaiCapaianSkp60 = $nilaiCapaianSkp * 0.6;
            $nilaiPerilaku40   = $nilaiPerilaku * 0.4;
            $nilaiAkhir        = $nilaiCapaianSkp60 + $nilaiPerilaku40;
            $kategori          = $this->getKategori($nilaiAkhir);

            // set ke template
            $template->setValue('nilai_capaian_skp', number_format($nilaiCapaianSkp, 2));
            $template->setValue('nilai_capaian_skp_60', number_format($nilaiCapaianSkp60, 2));
            $template->setValue('nilai_perilaku_40', number_format($nilaiPerilaku40, 2));
            $template->setValue('nilai_akhir', number_format($nilaiAkhir, 2));
            $template->setValue('kategori', $kategori);

            // === HEADER IDENTITAS ===
            $template->setValue('tahun', $skp->tahun);
            $template->setValue('nama_dinilai', $pegawaiDinilai->nama ?? $pegawaiDinilai->nama_lengkap ?? '-');
            $template->setValue('nip_dinilai', $pegawaiDinilai->nip ?? '-');
            $template->setValue('pangkat_dinilai', $pegawaiDinilai->pangkat_golongan ?? '-');
            $template->setValue('jabatan_dinilai', $pegawaiDinilai->jabatan->nama->nama_jabatan ?? $pegawaiDinilai->jabatan->nama_jabatan ?? '-');
            $template->setValue('unit_dinilai', $pegawaiDinilai->jabatan->unit_kerja ?? '-');

            $template->setValue('nama_penilai', $pegawaiPenilai->nama ?? $pegawaiPenilai->nama_lengkap ?? '-');
            $template->setValue('nip_penilai', $pegawaiPenilai->nip ?? '-');
            $template->setValue('pangkat_penilai', $pegawaiPenilai->pangkat_golongan ?? '-');
            $template->setValue('jabatan_penilai', $pegawaiPenilai->jabatan->nama->nama_jabatan ?? $pegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $template->setValue('unit_penilai', $pegawaiPenilai->jabatan->unit_kerja ?? '-');

            $template->setValue('nama_atasan', $atasanPenilai->nama ?? $atasanPenilai->nama_lengkap ?? '-');
            $template->setValue('nip_atasan', $atasanPenilai->nip ?? '-');
            $template->setValue('pangkat_atasan', $atasanPenilai->pangkat_golongan ?? '-');
            $template->setValue('jabatan_atasan', $atasanPenilai->jabatan->nama->nama_jabatan ?? $atasanPenilai->jabatan->nama_jabatan ?? '-');
            $template->setValue('unit_atasan', $atasanPenilai->jabatan->unit_kerja ?? '-');

            $tanggalDoc = $catatan && $catatan->tanggal
                ? Carbon::parse($catatan->tanggal)->translatedFormat('d F Y')
                : Carbon::now()->translatedFormat('d F Y');

            $template->setValue('tanggal', $tanggalDoc);

            // === TABEL FORMULIR (TARGET) ===
            $jumlahKegiatan = $skp->kegiatan->count();
            if ($jumlahKegiatan > 0) {
                $template->cloneRow('no_form', $jumlahKegiatan);

                foreach ($skp->kegiatan as $i => $k) {
                    $row = $i + 1;

                    $template->setValue("no_form#{$row}", $row);
                    $template->setValue("nama_kegiatan_form#{$row}", $k->nama_kegiatan ?? '-');
                    $template->setValue("ak_form#{$row}", $k->ak ?? '-');
                    $template->setValue("target_output_form#{$row}", $k->target_kuantitatif_output ?? '-');
                    $template->setValue("jenis_kegiatan_form#{$row}", $k->jenis_kegiatan ?? '-');
                    $template->setValue("target_mutu_form#{$row}", $k->target_kualitatif_mutu ?? '-');
                    $template->setValue("target_waktu_form#{$row}", $k->target_waktu_bulan ?? '-');
                    $template->setValue("target_biaya_form#{$row}", $k->target_biaya ?? '-');
                }
            }

            if ($jumlahKegiatan > 0) {
                $template->cloneRow('no_capaian', $jumlahKegiatan);

                foreach ($skp->kegiatan as $i => $k) {
                    $row = $i + 1;

                    $nk = $this->calculateNilaiKegiatan($k->toArray());
                    $nc = is_numeric($nk) ? ((float)$nk / 4) : 0;

                    $template->setValue("no_capaian#{$row}", $row);
                    $template->setValue("nama_kegiatan#{$row}", $k->nama_kegiatan ?? '-');
                    $template->setValue("target_output#{$row}", $k->target_kuantitatif_output ?? '-');
                    $template->setValue("jenis_kegiatan#{$row}", $k->jenis_kegiatan ?? '-');
                    $template->setValue("target_mutu#{$row}", $k->target_kualitatif_mutu ?? '-');
                    $template->setValue("target_waktu#{$row}", $k->target_waktu_bulan ?? '-');
                    $template->setValue("target_biaya#{$row}", $k->target_biaya ?? '-');

                    $template->setValue("realisasi_output#{$row}", $k->realisasi_kuantitatif_output ?? '-');
                    $template->setValue("realisasi_mutu#{$row}",   $k->realisasi_kualitatif_mutu ?? '-');
                    $template->setValue("realisasi_waktu#{$row}",  $k->realisasi_waktu_bulan ?? '-');
                    $template->setValue("realisasi_biaya#{$row}",  $k->realisasi_biaya ?? '-');

                    $template->setValue("nilai_kegiatan#{$row}", number_format((float)$nk, 2));
                    $template->setValue("nilai_capaian#{$row}",  number_format((float)$nc, 2));
                }
            }

            // === TABEL TUGAS TAMBAHAN ===
            $jumlahTambahan = $skp->tugasTambahan->count();
            if ($jumlahTambahan > 0) {
                $template->cloneRow('no_tambahan', $jumlahTambahan);
                foreach ($skp->tugasTambahan as $i => $tambahan) {
                    $row = $i + 1;
                    $template->setValue("no_tambahan#{$row}", $row);
                    $template->setValue("nama_tambahan#{$row}", $tambahan->nama_tambahan ?? '-');
                    $template->setValue("nilai_tambahan#{$row}", number_format((float)($tambahan->nilai_tambahan ?? 0), 2));
                }
            }

            // === NILAI CAPAIAN & KATEGORI ===
            $template->setValue('nilai_capaian_skp', number_format($nilaiCapaianSkp, 2));
            $template->setValue('kategori_total_capaian_skp', $this->getKategori($nilaiCapaianSkp));

            // === BUKU CATATAN PERILAKU ===
            $perilakuValues = $this->extractPerilakuFromUraian($catatan->uraian ?? '');

            $setAspek = function (string $key, string $ph) use ($template, $perilakuValues) {
                $raw = $perilakuValues[$key] ?? null;
                if (is_string($raw)) $raw = str_replace(',', '.', $raw);
                $num = is_numeric($raw) ? (float)$raw : null;

                $template->setValue($ph, $num !== null ? number_format($num, 2) : '-');
                $template->setValue("kategori_{$key}", $this->getKategori($num));

                return $num;
            };

            if ($catatan) {
                $template->setValue('nama', $pegawaiDinilai->nama ?? $pegawaiDinilai->nama_lengkap ?? '-');
                $template->setValue('nip',  $pegawaiDinilai->nip ?? '-');
                $template->setValue('total_capaian_skp', number_format($nilaiCapaianSkp, 2));

                $n1 = $setAspek('orientasi_pelayanan', 'orientasi_pelayanan');
                $n2 = $setAspek('integritas',           'integritas');
                $n3 = $setAspek('komitmen',             'komitmen');
                $n4 = $setAspek('disiplin',             'disiplin');
                $n5 = $setAspek('kerjasama',            'kerjasama');
                $n6 = $setAspek('kepemimpinan',         'kepemimpinan');

                $nums = array_filter([$n1,$n2,$n3,$n4,$n5,$n6], fn($v) => $v !== null);
                $template->setValue('jumlah_nilai_perilaku', number_format(array_sum($nums), 2));

                $template->setValue('nilai_perilaku', number_format($nilaiPerilaku, 2));
                $template->setValue('kategori_perilaku', $this->getKategori($nilaiPerilaku));
                $template->setValue('rata_rata', number_format($nilaiPerilaku, 2)); // kalau template butuh ini
            }

            // === TABEL AKHIR ===
            $template->setValue('nilai_capaian_skp_60', number_format($nilaiCapaianSkp60, 2));
            $template->setValue('nilai_perilaku_40',    number_format($nilaiPerilaku40, 2));
            $template->setValue('nilai_akhir',          number_format($nilaiAkhir, 2));
            $template->setValue('kategori',             $kategori);

            // === SAVE ===
            $fileName = 'SKP-' . ($pegawaiDinilai->nip ?? 'unknown') . '-' . $skp->tahun . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), 'SKP_Word_');
            $template->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Error cetakWord: ' . $e->getMessage(), [
                'skp_id' => $skp->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat dokumen Word: ' . $e->getMessage());
        }
    }

    /**
     * Mencetak SKP ke format Excel.
     */ 

    public function cetakExcel(SkpHeader $skp)
    {
        try {
            // === LOAD DATA ===
            $skp->load([
                'pegawaiDinilai.jabatan',
                'pegawaiPenilai.jabatan',
                'atasanPegawaiPenilai.jabatan',
                'kegiatan',
                'tugasTambahan',
                'catatanPenilaian',
            ]);

            // === HITUNG NILAI (match Word) ===
            $capaianList = [];
            $nilaiKegiatanList = [];

            foreach ($skp->kegiatan as $k) {
                // Σ 4 aspek
                $nk = $this->calculateNilaiKegiatan($k->toArray());
                $nkNum = is_numeric($nk) ? (float)$nk : null;
                $nilaiKegiatanList[] = $nkNum;

                // capaian per kegiatan → gunakan kolom DB kalau ada, fallback = Σ/4
                $cap = $k->nilai_capaian ?? null;
                if (is_string($cap)) $cap = str_replace(',', '.', $cap);
                $capaianList[] = is_numeric($cap) ? (float)$cap : ($nkNum !== null ? $nkNum / 4.0 : 0.0);
            }

            $jmlKeg       = count($capaianList);
            $rataKegiatan = $jmlKeg > 0 ? array_sum($capaianList) / $jmlKeg : 0.0;

            $totalNilaiTambahan = 0.0;
            foreach ($skp->tugasTambahan as $t) {
                $v = $t->nilai_tambahan ?? null;
                if (is_string($v)) $v = str_replace(',', '.', $v);
                if (is_numeric($v)) $totalNilaiTambahan += (float)$v;
            }

            // Nilai capaian SKP (versi yang dipakai): rata-rata kegiatan + total tambahan
            $nilaiCapaianSkp = $rataKegiatan + $totalNilaiTambahan;
            $nilaiPerilaku   = is_numeric($skp->nilai_perilaku) ? (float)$skp->nilai_perilaku : 0.0;

            $nilaiCapaianSkp60 = $nilaiCapaianSkp * 0.6;
            $nilaiPerilaku40   = $nilaiPerilaku * 0.4;
            $nilaiAkhir        = $nilaiCapaianSkp60 + $nilaiPerilaku40;
            $kategoriAkhir     = $this->getKategori($nilaiAkhir);

            // Perilaku per-aspek (dari uraian catatan)
            $perilaku = $this->extractPerilakuFromUraian($skp->catatanPenilaian->uraian ?? '');
            $toNum = function ($x) {
                if (is_string($x)) $x = str_replace(',', '.', $x);
                return is_numeric($x) ? (float)$x : null;
            };
            $ori = $toNum($perilaku['orientasi_pelayanan'] ?? null);
            $int = $toNum($perilaku['integritas'] ?? null);
            $kom = $toNum($perilaku['komitmen'] ?? null);
            $dis = $toNum($perilaku['disiplin'] ?? null);
            $ker = $toNum($perilaku['kerjasama'] ?? null);
            $kep = $toNum($perilaku['kepemimpinan'] ?? null);
            $kat = fn(?float $n) => $this->getKategori($n);
            $katOri = $kat($ori); $katInt = $kat($int); $katKom = $kat($kom);
            $katDis = $kat($dis); $katKer = $kat($ker); $katKep = $kat($kep);

            // === LOAD TEMPLATE ===
            $templatePath = storage_path('app/templates/skp.xlsx');
            if (!file_exists($templatePath)) {
                return back()->with('error', 'Template Excel tidak ditemukan.');
            }
            $spreadsheet = IOFactory::load($templatePath);

            // === MAP KOORDINAT ===
            $map = [
                // SHEET 2: data skp
                'data_skp' => [
                    'sheet' => 'data skp',
                    'cells' => [
                        'nama_dinilai'    => 'E4',
                        'nip_dinilai'     => 'E5',
                        'pangkat_dinilai' => 'E6',
                        'jabatan_dinilai' => 'E7',
                        'unit_dinilai'    => 'E8',

                        'nama_penilai'    => 'E10',
                        'nip_penilai'     => 'E11',
                        'pangkat_penilai' => 'E12',
                        'jabatan_penilai' => 'E13',
                        'unit_penilai'    => 'E14',

                        'nama_atasan'     => 'E16',
                        'nip_atasan'      => 'E17',
                        'pangkat_atasan'  => 'E18',
                        'jabatan_atasan'  => 'E19',
                        'unit_atasan'     => 'E20',
                    ],
                ],

                // SHEET 3: cover
                'cover' => [
                    'sheet' => 'cover',
                    'cells' => [
                        'nama_dinilai'    => 'F18',
                        'nip_dinilai'     => 'F19',
                        'pangkat_dinilai' => 'F20',
                        'jabatan_dinilai' => 'F21',
                        'unit_dinilai'    => 'F22',
                    ],
                ],

                // SHEET 4: form skp (TARGET)
                'form_skp' => [
                    'sheet'     => 'form skp',
                    'start_row' => 11,
                    'cells'     => [
                        'nama_penilai'    => 'C4',
                        'nip_penilai'     => 'C5',
                        'pangkat_penilai' => 'C6',
                        'jabatan_penilai' => 'C7',
                        'unit_penilai'    => 'C8',

                        'nama_dinilai'    => 'G4',
                        'nip_dinilai'     => 'G5',
                        'pangkat_dinilai' => 'G6',
                        'jabatan_dinilai' => 'G7',
                        'unit_dinilai'    => 'G8',

                        'tanggal'         => 'F19',
                        'ttd_nama_penilai'=> 'C25',
                        'ttd_nip_penilai' => 'C26',
                        'ttd_nama_dinilai'=> 'F25',
                        'ttd_nip_dinilai' => 'F26',
                    ],
                    'table'     => [
                        'A' => '__rownum',
                        'B' => 'nama_kegiatan',
                        'D' => 'ak',
                        'E' => 'target_kuantitatif_output',
                        'F' => 'jenis_kegiatan',
                        'G' => 'target_kualitatif_mutu',
                        'H' => 'target_waktu_bulan',
                        'I' => 'target_biaya',
                    ],
                    'number_cols' => ['D','H','I'],
                    'last_col'    => 'I',
                ],

                // SHEET 5: pengukuran (REALISASI + NILAI) + tugas tambahan
                'pengukuran' => [
                    'sheet'     => 'pengukuran',
                    'start_row' => 9,
                    'cells'     => [
                        'nama_dinilai' => 'K4',
                        'nip_dinilai'  => 'K5',
                        'nama_penilai' => 'K31',
                        'nip_penilai'  => 'K32',
                    ],
                    'table' => [
                        'A' => '__rownum',
                        'B' => 'nama_kegiatan',
                        'C' => 'target_kuantitatif_output',
                        'D' => 'jenis_kegiatan',
                        'E' => 'target_kualitatif_mutu',
                        'F' => 'target_waktu_bulan',
                        'H' => 'target_biaya',

                        'I'  => 'realisasi_kuantitatif_output',
                        'J'  => 'jenis_kegiatan',
                        'K'  => 'realisasi_kualitatif_mutu',
                        'L'  => 'realisasi_waktu_bulan',
                        'N'  => 'realisasi_biaya',

                        'O' => '__nilai_kegiatan', // Σ4 aspek
                        'P' => '__nilai_capaian',  // capaian per kegiatan
                    ],
                    'number_cols' => ['C','F','H','I','K','L','N','O','P'],
                    'last_col'    => 'P',
                ],

                // SHEET 6: perilaku kerja
                'perilaku' => [
                    'sheet' => 'perilaku kerja',
                    'cells' => [
                        'nilai_capaian_skp' => 'E10',
                        'orientasi'         => 'H12',
                        'integritas'        => 'H13',
                        'komitmen'          => 'H14',
                        'disiplin'          => 'H15',
                        'kerjasama'         => 'H16',
                        'kepemimpinan'      => 'H17',
                        'kat_orientasi'     => 'I12',
                        'kat_integritas'    => 'I13',
                        'kat_komitmen'      => 'I14',
                        'kat_disiplin'      => 'I15',
                        'kat_kerjasama'     => 'I16',
                        'kat_kepemimpinan'  => 'I17',
                        'jumlah_nilai'      => 'H18',
                        'rata'              => 'H19',
                        'kategori'          => 'I19',
                        'jabatan_penilai'   => 'J12',
                        'ttd_penilai_nama'  => 'J18',
                        'ttd_penilai_nip'   => 'J19',
                    ],
                ],

                // SHEET 7: penilaian (REKAP)
                'penilaian' => [
                    'sheet' => 'penilaian',
                    'cells' => [
                        'nama_dinilai'     => 'G14',
                        'nip_dinilai'      => 'G15',
                        'pangkat_dinilai'  => 'G16',
                        'jabatan_dinilai'  => 'G17',
                        'unit_dinilai'     => 'G18',

                        'nama_penilai'     => 'G20',
                        'nip_penilai'      => 'G21',
                        'pangkat_penilai'  => 'G22',
                        'jabatan_penilai'  => 'G23',
                        'unit_penilai'     => 'G24',

                        'nama_atasan'      => 'G26',
                        'nip_atasan'       => 'G27',
                        'pangkat_atasan'   => 'G28',
                        'jabatan_atasan'   => 'G29',
                        'unit_atasan'      => 'G30',

                        'orientasi'        => 'H34',
                        'integritas'       => 'H35',
                        'komitmen'         => 'H36',
                        'disiplin'         => 'H37',
                        'kerjasama'        => 'H38',
                        'kepemimpinan'     => 'H39',

                        'kat_orientasi'    => 'I34',
                        'kat_integritas'   => 'I35',
                        'kat_komitmen'     => 'I36',
                        'kat_disiplin'     => 'I37',
                        'kat_kerjasama'    => 'I38',
                        'kat_kepemimpinan' => 'I39',

                        'jumlah_nilai'     => 'H40',
                        'rata'             => 'H41',

                        'nilai_capaian'    => 'H32',
                        'nilai_capaian_60' => 'J32',
                        'nilai_perilaku'   => 'H42',
                        'nilai_perilaku_40'=> 'J42',
                        'nilai_akhir'      => 'J43',
                        'kategori'         => 'J44',

                        'ttd_penilai_nama' => 'H133',
                        'ttd_penilai_nip'  => 'H134',
                        'ttd_dinilai_nama' => 'B143',
                        'ttd_dinilai_nip'  => 'B144',
                        'ttd_atasan_nama'  => 'H152',
                        'ttd_atasan_nip'   => 'H153',
                    ],
                    'number_cells' => ['H32','J32','H41','H42','J41','J43'],
                ],
            ];

            // ==== HELPERS ====
            $getSheet = function(string $name) use ($spreadsheet): Worksheet {
                $s = $spreadsheet->getSheetByName($name);
                if ($s instanceof Worksheet) return $s;
                foreach ($spreadsheet->getWorksheetIterator() as $ws) {
                    if (mb_strtolower(trim($ws->getTitle())) === mb_strtolower(trim($name))) return $ws;
                }
                return $spreadsheet->getSheet(0);
            };

            $expandRows = function(Worksheet $sheet, int $startRow, int $totalRows, string $lastCol) {
                if ($totalRows <= 1) return;
                $sheet->insertNewRowBefore($startRow + 1, $totalRows - 1);
                for ($i = 1; $i < $totalRows; $i++) {
                    $src = "A{$startRow}:{$lastCol}{$startRow}";
                    $dst = "A".($startRow+$i).":{$lastCol}".($startRow+$i);
                    $sheet->duplicateStyle($sheet->getStyle($src), $dst);
                    $sheet->getRowDimension($startRow+$i)
                        ->setRowHeight($sheet->getRowDimension($startRow)->getRowHeight());
                }
            };

            // ==== SHEET: DATA SKP ====
            $sData = $getSheet($map['data_skp']['sheet']);
            $cd = $map['data_skp']['cells'];
            $sData->setCellValue($cd['nama_dinilai'],    $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sData->setCellValue($cd['nip_dinilai'],     $skp->pegawaiDinilai->nip ?? '-');
            $sData->setCellValue($cd['pangkat_dinilai'], $skp->pegawaiDinilai->pangkat_golongan ?? '-');
            $sData->setCellValue($cd['jabatan_dinilai'], $skp->pegawaiDinilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-');
            $sData->setCellValue($cd['unit_dinilai'],    $skp->pegawaiDinilai->jabatan->unit_kerja ?? '-');

            $sData->setCellValue($cd['nama_penilai'],    $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sData->setCellValue($cd['nip_penilai'],     $skp->pegawaiPenilai->nip ?? '-');
            $sData->setCellValue($cd['pangkat_penilai'], $skp->pegawaiPenilai->pangkat_golongan ?? '-');
            $sData->setCellValue($cd['jabatan_penilai'], $skp->pegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sData->setCellValue($cd['unit_penilai'],    $skp->pegawaiPenilai->jabatan->unit_kerja ?? '-');

            $sData->setCellValue($cd['nama_atasan'],     $skp->atasanPegawaiPenilai->nama ?? $skp->atasanPegawaiPenilai->nama_lengkap ?? '-');
            $sData->setCellValue($cd['nip_atasan'],      $skp->atasanPegawaiPenilai->nip ?? '-');
            $sData->setCellValue($cd['pangkat_atasan'],  $skp->atasanPegawaiPenilai->pangkat_golongan ?? '-');
            $sData->setCellValue($cd['jabatan_atasan'],  $skp->atasanPegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sData->setCellValue($cd['unit_atasan'],     $skp->atasanPegawaiPenilai->jabatan->unit_kerja ?? '-');

            // ==== SHEET: COVER ====
            $sCover = $getSheet($map['cover']['sheet']);
            $cc = $map['cover']['cells'];
            $sCover->setCellValue($cc['nama_dinilai'],    $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sCover->setCellValue($cc['nip_dinilai'],     $skp->pegawaiDinilai->nip ?? '-');
            $sCover->setCellValue($cc['pangkat_dinilai'], $skp->pegawaiDinilai->pangkat_golongan ?? '-');
            $sCover->setCellValue($cc['jabatan_dinilai'], $skp->pegawaiDinilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-');
            $sCover->setCellValue($cc['unit_dinilai'],    $skp->pegawaiDinilai->jabatan->unit_kerja ?? '-');

            // ==== SHEET: FORM SKP (TARGET) ====
            $sForm   = $getSheet($map['form_skp']['sheet']);
            $cf      = $map['form_skp']['cells'];
            $startF  = $map['form_skp']['start_row'];
            $lastColF= $map['form_skp']['last_col'];

            // identitas form
            $sForm->setCellValue($cf['nama_penilai'],     $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sForm->setCellValue($cf['nip_penilai'],      $skp->pegawaiPenilai->nip ?? '-');
            $sForm->setCellValue($cf['pangkat_penilai'],  $skp->pegawaiPenilai->pangkat_golongan ?? '-');
            $sForm->setCellValue($cf['jabatan_penilai'],  $skp->pegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sForm->setCellValue($cf['unit_penilai'],     $skp->pegawaiPenilai->jabatan->unit_kerja ?? '-');
            $sForm->setCellValue($cf['ttd_nama_penilai'],     $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sForm->setCellValue($cf['ttd_nip_penilai'],      $skp->pegawaiPenilai->nip ?? '-');

            $sForm->setCellValue($cf['nama_dinilai'],     $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sForm->setCellValue($cf['nip_dinilai'],      $skp->pegawaiDinilai->nip ?? '-');
            $sForm->setCellValue($cf['pangkat_dinilai'],  $skp->pegawaiDinilai->pangkat_golongan ?? '-');
            $sForm->setCellValue($cf['jabatan_dinilai'],  $skp->pegawaiDinilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-');
            $sForm->setCellValue($cf['unit_dinilai'],     $skp->pegawaiDinilai->jabatan->unit_kerja ?? '-');
            $sForm->setCellValue($cf['ttd_nama_dinilai'],     $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sForm->setCellValue($cf['ttd_nip_dinilai'],      $skp->pegawaiDinilai->nip ?? '-');
            
            $sForm->setCellValue($cf['tanggal'],          Carbon::now()->translatedFormat('d F Y'));

            // tabel target
            $expandRows($sForm, $startF, max(1, $skp->kegiatan->count()), $lastColF);
            $r = $startF;
            foreach ($skp->kegiatan as $i => $k) {
                foreach ($map['form_skp']['table'] as $col => $field) {
                    $val = $field === '__rownum' ? ($i + 1) : data_get($k, $field, '-');
                    $sForm->setCellValue("{$col}{$r}", $val);
                }
                $r++;
            }
            foreach ($map['form_skp']['number_cols'] as $col) {
                $sForm->getStyle("{$col}{$startF}:{$col}".($r-1))
                    ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            // ==== SHEET: PENGUKURAN (REALISASI + NILAI) ====
            $sCap    = $getSheet($map['pengukuran']['sheet']);
            $ccap    = $map['pengukuran']['cells'];
            $startC  = $map['pengukuran']['start_row'];
            $lastColC= $map['pengukuran']['last_col'];

            $sCap->setCellValue($ccap['nama_dinilai'], $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sCap->setCellValue($ccap['nip_dinilai'],  $skp->pegawaiDinilai->nip ?? '-');
            $sCap->setCellValue($ccap['nama_penilai'], $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sCap->setCellValue($ccap['nip_penilai'],  $skp->pegawaiPenilai->nip ?? '-');

            // expand rows = kegiatan + tugas tambahan
            $totalRowsPengukuran = max(1, $skp->kegiatan->count() + $skp->tugasTambahan->count());
            $expandRows($sCap, $startC, $totalRowsPengukuran, $lastColC);

            $r = $startC;
            $i = 0;

            // loop kegiatan
            foreach ($skp->kegiatan as $idx => $k) {
                foreach ($map['pengukuran']['table'] as $col => $field) {
                    if ($field === '__rownum') {
                        $sCap->setCellValue("{$col}{$r}", $i + 1);
                    } elseif ($field === '__nilai_kegiatan') {
                        $nk = $nilaiKegiatanList[$idx] ?? null;
                        $sCap->setCellValue("{$col}{$r}", $nk !== null ? (float)$nk : null);
                    } elseif ($field === '__nilai_capaian') {
                        $cap = $capaianList[$idx] ?? 0.0;
                        $sCap->setCellValue("{$col}{$r}", (float)$cap);
                    } else {
                        $sCap->setCellValue("{$col}{$r}", data_get($k, $field, '-'));
                    }
                }
                // optional label "bln"
                $sCap->setCellValue("G{$r}", 'bln'); 
                $sCap->setCellValue("M{$r}", 'bln');
                $r++; $i++;
            }

            $sCap = $getSheet('pengukuran');

            // ambil hanya 1 tugas tambahan pertama
            $tmb = $skp->tugasTambahan->first();

            if ($tmb) {
                $rowTambahanStart = 20;

                // Nama tambahan di B20
                $sCap->setCellValue("B{$rowTambahanStart}", $tmb->nama_tambahan ?? 'Tugas Tambahan');

                // Nilai tambahan di P20
                $valTambahan = $tmb->nilai_tambahan;
                if (is_string($valTambahan)) {
                    $valTambahan = str_replace(',', '.', $valTambahan);
                }
                $valTambahan = is_numeric($valTambahan) ? (float)$valTambahan : 0.0;

                $sCap->setCellValue("P{$rowTambahanStart}", $valTambahan);

                // Format angka (2 desimal)
                $sCap->getStyle("P{$rowTambahanStart}")
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
            }

            // === REKAP DI P24 & P25 ===
            $sCap->setCellValue('P24', $nilaiCapaianSkp);
            $sCap->getStyle('P24')->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);

            $sCap->setCellValue('P25', $this->getKategori($nilaiCapaianSkp));


            // format angka pengukuran
            foreach ($map['pengukuran']['number_cols'] as $col) {
                $sCap->getStyle("{$col}{$startC}:{$col}".($r-1))
                    ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            // ==== SHEET: PERILAKU KERJA ====
            $sPer = $getSheet($map['perilaku']['sheet']);
            $cp   = $map['perilaku']['cells'];
            $sPer->setCellValue($cp['nilai_capaian_skp'], $nilaiCapaianSkp);

            if ($ori !== null) $sPer->setCellValue($cp['orientasi'], $ori);
            if ($int !== null) $sPer->setCellValue($cp['integritas'], $int);
            if ($kom !== null) $sPer->setCellValue($cp['komitmen'], $kom);
            if ($dis !== null) $sPer->setCellValue($cp['disiplin'], $dis);
            if ($ker !== null) $sPer->setCellValue($cp['kerjasama'], $ker);
            if ($kep !== null) $sPer->setCellValue($cp['kepemimpinan'], $kep);

            $sPer->setCellValue($cp['kat_orientasi'],    $katOri);
            $sPer->setCellValue($cp['kat_integritas'],   $katInt);
            $sPer->setCellValue($cp['kat_komitmen'],     $katKom);
            $sPer->setCellValue($cp['kat_disiplin'],     $katDis);
            $sPer->setCellValue($cp['kat_kerjasama'],    $katKer);
            $sPer->setCellValue($cp['kat_kepemimpinan'], $katKep);

            $jumlahPer = array_sum(array_filter([$ori,$int,$kom,$dis,$ker,$kep], fn($v)=>$v!==null));
            $sPer->setCellValue($cp['jumlah_nilai'], $jumlahPer);
            $sPer->setCellValue($cp['rata'], $nilaiPerilaku);
            $sPer->setCellValue($cp['kategori'], $this->getKategori($nilaiPerilaku));
            $sPer->setCellValue($cp['jabatan_penilai'], $skp->pegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sPer->setCellValue($cp['ttd_penilai_nama'], $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sPer->setCellValue($cp['ttd_penilai_nip'],  $skp->pegawaiPenilai->nip ?? '-');

            // formatting angka sheet perilaku
            foreach (['orientasi','integritas','komitmen','disiplin','kerjasama','kepemimpinan','jumlah_nilai','rata'] as $k) {
                if (isset($cp[$k])) $sPer->getStyle($cp[$k])->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            // ==== SHEET: PENILAIAN (REKAP) ====
            $sPen = $getSheet($map['penilaian']['sheet']);
            $cs   = $map['penilaian']['cells'];

            // identitas
            $sPen->setCellValue($cs['nama_dinilai'],    $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['nip_dinilai'],     $skp->pegawaiDinilai->nip ?? '-');
            $sPen->setCellValue($cs['pangkat_dinilai'], $skp->pegawaiDinilai->pangkat_golongan ?? '-');
            $sPen->setCellValue($cs['jabatan_dinilai'], $skp->pegawaiDinilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiDinilai->jabatan->nama_jabatan ?? '-');
            $sPen->setCellValue($cs['unit_dinilai'],    $skp->pegawaiDinilai->jabatan->unit_kerja ?? '-');

            $sPen->setCellValue($cs['nama_penilai'],    $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['nip_penilai'],     $skp->pegawaiPenilai->nip ?? '-');
            $sPen->setCellValue($cs['pangkat_penilai'], $skp->pegawaiPenilai->pangkat_golongan ?? '-');
            $sPen->setCellValue($cs['jabatan_penilai'], $skp->pegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->pegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sPen->setCellValue($cs['unit_penilai'],    $skp->pegawaiPenilai->jabatan->unit_kerja ?? '-');
            
            $sPen->setCellValue($cs['nama_atasan'],     $skp->atasanPegawaiPenilai->nama ?? $skp->atasanPegawaiPenilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['nip_atasan'],      $skp->atasanPegawaiPenilai->nip ?? '-');
            $sPen->setCellValue($cs['pangkat_atasan'],  $skp->atasanPegawaiPenilai->pangkat_golongan ?? '-');
            $sPen->setCellValue($cs['jabatan_atasan'],  $skp->atasanPegawaiPenilai->jabatan->nama->nama_jabatan ?? $skp->atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-');
            $sPen->setCellValue($cs['unit_atasan'],     $skp->atasanPegawaiPenilai->jabatan->unit_kerja ?? '-');

            // perilaku per aspek + kategori (opsional)
            if ($ori !== null) $sPen->setCellValue($cs['orientasi'], $ori);
            if ($int !== null) $sPen->setCellValue($cs['integritas'], $int);
            if ($kom !== null) $sPen->setCellValue($cs['komitmen'], $kom);
            if ($dis !== null) $sPen->setCellValue($cs['disiplin'], $dis);
            if ($ker !== null) $sPen->setCellValue($cs['kerjasama'], $ker);
            if ($kep !== null) $sPen->setCellValue($cs['kepemimpinan'], $kep);

            $sPen->setCellValue($cs['kat_orientasi'],    $katOri);
            $sPen->setCellValue($cs['kat_integritas'],   $katInt);
            $sPen->setCellValue($cs['kat_komitmen'],     $katKom);
            $sPen->setCellValue($cs['kat_disiplin'],     $katDis);
            $sPen->setCellValue($cs['kat_kerjasama'],    $katKer);
            $sPen->setCellValue($cs['kat_kepemimpinan'], $katKep);

            // rekap nilai
            $jumlahPer = array_sum(array_filter([$ori,$int,$kom,$dis,$ker,$kep], fn($v) => $v !== null));
            $sPen->setCellValue($cs['jumlah_nilai'], $jumlahPer);
            $sPen->getStyle($cs['jumlah_nilai'])->getNumberFormat() ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
            $sPen->setCellValue($cs['rata'],             $nilaiPerilaku);
            $sPen->setCellValue($cs['nilai_capaian'],    $nilaiCapaianSkp);
            $sPen->setCellValue($cs['nilai_capaian_60'], $nilaiCapaianSkp60);
            $sPen->setCellValue($cs['nilai_perilaku'],   $nilaiPerilaku);
            $sPen->setCellValue($cs['nilai_perilaku_40'],$nilaiPerilaku40);
            $sPen->setCellValue($cs['nilai_akhir'],      $nilaiAkhir);
            $sPen->setCellValue($cs['kategori'],         $kategoriAkhir);

            // tanda tangan
            $sPen->setCellValue($cs['ttd_penilai_nama'], $skp->pegawaiPenilai->nama ?? $skp->pegawaiPenilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['ttd_penilai_nip'],  $skp->pegawaiPenilai->nip ?? '-');
            $sPen->setCellValue($cs['ttd_dinilai_nama'], $skp->pegawaiDinilai->nama ?? $skp->pegawaiDinilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['ttd_dinilai_nip'],  $skp->pegawaiDinilai->nip ?? '-');
            $sPen->setCellValue($cs['ttd_atasan_nama'],  $skp->atasanPegawaiPenilai->nama ?? $skp->atasanPegawaiPenilai->nama_lengkap ?? '-');
            $sPen->setCellValue($cs['ttd_atasan_nip'],   $skp->atasanPegawaiPenilai->nip ?? '-');

            // formatting angka sheet penilaian
            foreach ($map['penilaian']['number_cells'] as $cell) {
                $sPen->getStyle($cell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }
            // nilai aspek juga biar rapi
            foreach (['orientasi','integritas','komitmen','disiplin','kerjasama','kepemimpinan','rata'] as $k) {
                if (isset($cs[$k])) $sPen->getStyle($cs[$k])->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            // ==== DOWNLOAD ====
            $writer   = new Xlsx($spreadsheet);
            $fileName = 'SKP-' . ($skp->pegawaiDinilai->nip ?? 'unknown') . '-' . $skp->tahun . '.xlsx';

            $tempFile = tempnam(sys_get_temp_dir(), 'SKP_Excel_');
            $writer->save($tempFile);

            $headers = [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control'       => 'max-age=0',
            ];

            return Response::download($tempFile, $fileName, $headers)->deleteFileAfterSend(true);

        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membuat file Excel: '.$e->getMessage());
        }
    }

    /**
     * Extract perilaku values from uraian text
     */
    private function extractPerilakuFromUraian($uraian)
    {
        $perilakuValues = [
            'orientasi_pelayanan' => null,
            'integritas' => null,
            'komitmen' => null,
            'disiplin' => null,
            'kerjasama' => null,
            'kepemimpinan' => null
        ];

        if (empty($uraian)) {
            return $perilakuValues;
        }

        // Pattern untuk menangkap nilai dari uraian
        $patterns = [
            'orientasi_pelayanan' => '/Orientasi\s+Pelayanan\s*:\s*([0-9]+\.?[0-9]*|-)/i',
            'integritas' => '/Integritas\s*:\s*([0-9]+\.?[0-9]*|-)/i',
            'komitmen' => '/Komitmen\s*:\s*([0-9]+\.?[0-9]*|-)/i',
            'disiplin' => '/Disiplin\s*:\s*([0-9]+\.?[0-9]*|-)/i',
            'kerjasama' => '/Kerjasama\s*:\s*([0-9]+\.?[0-9]*|-)/i',
            'kepemimpinan' => '/Kepemimpinan\s*:\s*([0-9]+\.?[0-9]*|-)/i'
        ];

        foreach ($patterns as $key => $pattern) {
            if (preg_match($pattern, $uraian, $matches)) {
                $value = trim($matches[1]);
                if ($value !== '-' && is_numeric($value)) {
                    $perilakuValues[$key] = floatval($value);
                }
            }
        }

        return $perilakuValues;
    }

    /**
     * Format uraian perilaku untuk disimpan ke database
     */
    private function formatUraianPerilaku($data): string
    {
        $labelMap = [
            'orientasi_pelayanan' => 'Orientasi Pelayanan',
            'integritas'          => 'Integritas',
            'komitmen'            => 'Komitmen',
            'disiplin'            => 'Disiplin',
            'kerjasama'           => 'Kerjasama',
            'kepemimpinan'        => 'Kepemimpinan',
        ];

        $lines = ["Aspek Perilaku Pegawai", ""];

        foreach ($labelMap as $key => $label) {
            $row = $data[$key] ?? null;

            // Normalisasi jadi ($nilai, $kategori)
            $nilai = null;
            $kategori = '-';

            if (is_array($row)) {
                $nilai    = $row['nilai'] ?? null;
                $kategori = $row['kategori'] ?? ($nilai !== null ? $this->getKategori((float)$nilai) : '-');
            } elseif ($row !== null && $row !== '-') {
                // Bisa angka mentah atau teks kategori
                $raw = str_replace(',', '.', (string)$row);
                if (is_numeric($raw)) {
                    $nilai    = (float)$raw;
                    $kategori = $this->getKategori($nilai);
                } else {
                    // Misal udah dapet teks kategori langsung
                    $kategori = (string)$row;
                }
            }

            // Format angka lokal (88,5 / 88) atau '-'
            $nilaiStr = $nilai !== null
                ? rtrim(rtrim(number_format($nilai, 2, ',', '.'), '0'), ',')
                : '-';

            // Rapiin kolom label biar sejajar saat dicetak monospace
            $lines[] = sprintf('%-20s : %s — %s', $label, $nilaiStr, $kategori);
        }

        return implode("\n", $lines);
    }

    /**
    * Menghitung nilai per kegiatan.
    */
    private function calculateNilaiKegiatan(array $data): float
    {
        $targetKuantitatif = max((float) ($data['target_kuantitatif_output'] ?? 1), 1);
        $realisasiKuantitatif = (float) ($data['realisasi_kuantitatif_output'] ?? 0);
        $targetKualitatif = max((float) ($data['target_kualitatif_mutu'] ?? 1), 1);
        $realisasiKualitatif = (float) ($data['realisasi_kualitatif_mutu'] ?? 0);
        $targetWaktu = max((float) ($data['target_waktu_bulan'] ?? 1), 1);
        $realisasiWaktu = (float) ($data['realisasi_waktu_bulan'] ?? 0);
        $targetBiaya = max((float) ($data['target_biaya'] ?? 1), 1);
        $realisasiBiaya = (float) ($data['realisasi_biaya'] ?? 0);

        // Menghitung nilai per aspek
        $nilaiKuantitatif = ($realisasiKuantitatif / $targetKuantitatif) * 100;
        
        $nilaiKualitatif = ($realisasiKualitatif / $targetKualitatif) * 100;
        
        // Perhitungan aspek Waktu
        if ($realisasiWaktu > $targetWaktu) {
            $nilaiWaktu = max(0, 100 - (($realisasiWaktu - $targetWaktu) / $targetWaktu) * 100);
        } else {
            if ($targetWaktu > 0) {
                $tingkatEfisiensiWaktu = (($targetWaktu - $realisasiWaktu) / $targetWaktu) * 100;

                if ($tingkatEfisiensiWaktu <= 24) {
                    $nilaiWaktu = (1.76 * $targetWaktu - $realisasiWaktu) / $targetWaktu * 100;
                } else {
                    $nilaiWaktu = 76 + 2 * (100 - $tingkatEfisiensiWaktu);
                }
            } else {
                $nilaiWaktu = 100;
            }
        }

        // Perhitungan aspek Biaya
        if ($realisasiBiaya > $targetBiaya) {
            $nilaiBiaya = max(0, 100 - (($realisasiBiaya - $targetBiaya) / $targetBiaya) * 100);
        } else {
            if ($targetBiaya > 0) {
                $tingkatEfisiensiBiaya = (($targetBiaya - $realisasiBiaya) / $targetBiaya) * 100;

                if ($tingkatEfisiensiBiaya <= 24) {
                    $nilaiBiaya = (1.76 * $targetBiaya - $realisasiBiaya) / $targetBiaya * 100;
                } else {
                    $nilaiBiaya = 76 + 2 * (100 - $tingkatEfisiensiBiaya);
                }
            } else {
                $nilaiBiaya = 100;
            }
        }
        
        return $nilaiKuantitatif + $nilaiKualitatif + $nilaiWaktu + $nilaiBiaya;
    }

    /**
     * Menentukan kategori berdasarkan nilai akhir.
     */
    private function getKategori(?float $nilai): string
    {
        // Jika nilai adalah null, kembalikan string default
        if ($nilai === null) {
            return '-';
        }
        if ($nilai <= 50) {
            return 'Buruk';
        } elseif ($nilai <= 60) {
            return 'Kurang';
        } elseif ($nilai <= 75) {
            return 'Cukup';
        } elseif ($nilai <= 90) {
            return 'Baik';
        } else {
            return 'Sangat Baik';
        }
    }
}
