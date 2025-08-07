<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\SkpHeader;
use App\Models\SkpKegiatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\SkpCatatanPenilaian;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;

class SkpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SkpHeader::with(['pegawaiDinilai', 'pegawaiPenilai']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan tahun
                $q->where('tahun', 'like', "%$search%")
                  // Atau cari berdasarkan nama pegawai yang dinilai
                ->orWhereHas('pegawaiDinilai', function ($pegawai) use ($search) {
                    $pegawai->where('nama', 'like', "%$search%");
                });
            });
        }
        
        $skpHeaders = $query->latest()->paginate(10)->appends($request->query());
        
        // Ambil semua data pegawai
        $pegawais = Pegawai::all();
        
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
        $request->validate([
            'pegawai_dinilai_id' => 'required|exists:pegawais,id',
            'pegawai_penilai_id' => 'required|exists:pegawais,id',
            'atasan_pegawai_penilai_id' => 'required|exists:pegawais,id',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 5),
            'nilai_perilaku' => 'required|numeric|min:0|max:100',
            
            // Validasi untuk kegiatan
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
            
            // Validasi untuk catatan penilaian
            'catatan.*.tanggal' => 'nullable|date',
            'catatan.*.uraian' => 'nullable|string',
            'catatan.*.nama_pegawai_penilai' => 'nullable|string|max:255',
            'catatan.*.nip_pegawai_penilai' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Hitung nilai capaian SKP (rata-rata dari semua kegiatan)
            $totalNilaiKegiatan = 0;
            $jumlahKegiatan = count($request->kegiatan ?? []);
            
            if ($jumlahKegiatan > 0) {
                foreach ($request->kegiatan as $kegiatanData) {
                    $nilaiKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                    $totalNilaiKegiatan += $nilaiKegiatan;
                }
                $nilaiCapaianSkp = $totalNilaiKegiatan / $jumlahKegiatan;
            } else {
                $nilaiCapaianSkp = 0;
            }

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
                        'nilai_kegiatan' => $nilaiKegiatan,
                    ]);
                }
            }

            // Simpan catatan penilaian
            if ($request->has('catatan')) {
                foreach ($request->catatan as $catatanData) {
                    if (!empty($catatanData['tanggal']) && !empty($catatanData['uraian'])) {
                        $tanggal = Carbon::createFromFormat('d-m-Y', $catatanData['tanggal'])->format('Y-m-d');
                        SkpCatatanPenilaian::create([
                            'skp_header_id' => $skpHeader->id,
                            'tanggal' => $tanggal,
                            'uraian' => $catatanData['uraian'],
                            'nama_pegawai_penilai' => $catatanData['nama_pegawai_penilai'] ?? '',
                            'nip_pegawai_penilai' => $catatanData['nip_pegawai_penilai'] ?? '',
                        ]);
                    }
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
        // Muat relasi yang diperlukan
        $skp->load(['pegawaiDinilai', 'pegawaiPenilai', 'atasanPegawaiPenilai', 'kegiatan', 'catatanPenilaian']);

        return view('surat.skp.show', compact('skp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkpHeader $skp)
    {
        // Muat relasi yang diperlukan
        $skp->load(['kegiatan', 'catatanPenilaian']);
        
        // Pisahkan kegiatan berdasarkan jenisnya
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
            
            // Validasi untuk kegiatan
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
            
            // Validasi untuk catatan penilaian
            'catatan.*.tanggal' => 'nullable|date',
            'catatan.*.uraian' => 'nullable|string',
            'catatan.*.nama_pegawai_penilai' => 'nullable|string|max:255',
            'catatan.*.nip_pegawai_penilai' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $skp) {
            // Hapus kegiatan dan catatan lama
            $skp->kegiatan()->delete();
            $skp->catatanPenilaian()->delete();

            // Hitung nilai capaian SKP (rata-rata dari semua kegiatan)
            $totalNilaiKegiatan = 0;
            $jumlahKegiatan = count($request->kegiatan ?? []);
            
            if ($jumlahKegiatan > 0) {
                foreach ($request->kegiatan as $kegiatanData) {
                    $nilaiKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                    $totalNilaiKegiatan += $nilaiKegiatan;
                }
                $nilaiCapaianSkp = $totalNilaiKegiatan / $jumlahKegiatan;
            } else {
                $nilaiCapaianSkp = 0;
            }

            // Hitung nilai akhir (60% Capaian SKP + 40% Perilaku)
            $nilaiAkhir = ($nilaiCapaianSkp * 0.6) + ($request->nilai_perilaku * 0.4);
            
            // Tentukan kategori
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

            // Simpan kegiatan-kegiatan baru
            if ($request->has('kegiatan')) {
                foreach ($request->kegiatan as $kegiatanData) {
                    $nilaiKegiatan = $this->calculateNilaiKegiatan($kegiatanData);
                    
                    SkpKegiatan::create([
                        'skp_header_id' => $skp->id,
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
                        'nilai_kegiatan' => $nilaiKegiatan,
                    ]);
                }
            }

            // Simpan catatan penilaian baru
            if ($request->has('catatan')) {
                foreach ($request->catatan as $catatanData) {
                    if (!empty($catatanData['tanggal']) && !empty($catatanData['uraian'])) {
                        $tanggal = Carbon::createFromFormat('d-m-Y', $catatanData['tanggal'])->format('Y-m-d');
                        SkpCatatanPenilaian::create([
                            'skp_header_id' => $skp->id,
                            'tanggal' => $tanggal,
                            'uraian' => $catatanData['uraian'],
                            'nama_pegawai_penilai' => $catatanData['nama_pegawai_penilai'] ?? '',
                            'nip_pegawai_penilai' => $catatanData['nip_pegawai_penilai'] ?? '',
                        ]);
                    }
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
            $skp->delete();
            return redirect()->route('skp.index')->with('success', 'SKP berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus SKP: ' . $e->getMessage());
        }
    }

    /**
     * Mencetak SKP ke format PDF.
     */
    public function cetakPdf(SkpHeader $skp)
    {
        // Muat relasi yang diperlukan
        $skp->load(['pegawaiDinilai.jabatan', 'pegawaiPenilai.jabatan', 'atasanPegawaiPenilai.jabatan', 'kegiatan', 'catatanPenilaian']);

        // Pisahkan kegiatan berdasarkan jenisnya
        $kegiatanTugasJabatan = $skp->kegiatan->where('jenis_kegiatan', 'tugas_jabatan');
        $kegiatanTugasTambahan = $skp->kegiatan->where('jenis_kegiatan', 'tugas_tambahan');

        // Panggil fungsi getKategori dari controller dan simpan hasilnya di variabel baru
        $kategoriNilaiPerilaku = [
            'orientasi_pelayanan' => $this->getKategori($skp->nilai_perilaku_orientasi_pelayanan ?? 0.0),
            'integritas' => $this->getKategori($skp->nilai_perilaku_integritas ?? 0.0),
            'komitmen' => $this->getKategori($skp->nilai_perilaku_komitmen ?? 0.0),
            'disiplin' => $this->getKategori($skp->nilai_perilaku_disiplin ?? 0.0),
            'kerjasama' => $this->getKategori($skp->nilai_perilaku_kerjasama ?? 0.0),
            'kepemimpinan' => $this->getKategori($skp->nilai_perilaku_kepemimpinan ?? 0.0),
            'rata_rata' => $this->getKategori($skp->nilai_perilaku_rata_rata ?? 0.0),
        ];

        $pdf = Pdf::loadView('surat.skp.cetak.pdf', compact('skp', 'kegiatanTugasJabatan', 'kegiatanTugasTambahan', 'kategoriNilaiPerilaku'));

        return $pdf->stream('SKP-' . $skp->pegawaiDinilai->nip . '-' . $skp->tahun . '.pdf');
    }

    /**
     * Mencetak SKP ke format Word.
     */
    public function cetakWord(SkpHeader $skp)
    {
        // Muat relasi yang diperlukan
        // Pastikan relasi 'jabatan' dimuat untuk menggunakan accessor
        $skp->load(['pegawaiDinilai.jabatan', 'pegawaiPenilai.jabatan', 'atasanPegawaiPenilai.jabatan', 'kegiatan', 'catatanPenilaian']);

        // Pastikan Anda telah menyimpan template di storage/app/templates
        $templatePath = storage_path('app/templates/PENILAIAN PRESTASI KERJA.docx');
        
        // Buat instance TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        // Siapkan data untuk placeholder
        $pegawaiDinilai = $skp->pegawaiDinilai;
        $pegawaiPenilai = $skp->pegawaiPenilai;
        $atasanPegawaiPenilai = $skp->atasanPegawaiPenilai;
        $catatanPenilaian = $skp->catatanPenilaian->first();

        // Mengganti placeholder statis di template
        $templateProcessor->setValue('tahun', $skp->tahun);

        // Bagian Pegawai yang Dinilai
        $templateProcessor->setValue('nama_dinilai', $pegawaiDinilai->nama ?? '-');
        $templateProcessor->setValue('nip_dinilai', $pegawaiDinilai->nip ?? '-');
        $templateProcessor->setValue('pangkat_gol_dinilai', $pegawaiDinilai->pangkat_golongan);
        $templateProcessor->setValue('jabatan_dinilai', $pegawaiDinilai->jabatan->nama_jabatan ?? '-');

        // Bagian Pejabat Penilai
        $templateProcessor->setValue('nama_penilai', $pegawaiPenilai->nama ?? '-');
        $templateProcessor->setValue('nip_penilai', $pegawaiPenilai->nip ?? '-');
        $templateProcessor->setValue('pangkat_gol_penilai', $pegawaiPenilai->pangkat_golongan);
        $templateProcessor->setValue('jabatan_penilai', $pegawaiPenilai->jabatan->nama_jabatan ?? '-');

        // Bagian Atasan Pejabat Penilai
        $templateProcessor->setValue('nama_atasan', $atasanPegawaiPenilai->nama ?? '-');
        $templateProcessor->setValue('nip_atasan', $atasanPegawaiPenilai->nip ?? '-');
        $templateProcessor->setValue('pangkat_gol_atasan', $atasanPegawaiPenilai->pangkat_golongan);
        $templateProcessor->setValue('jabatan_atasan', $atasanPegawaiPenilai->jabatan->nama_jabatan ?? '-');

        $templateProcessor->setValue('nilai_perilaku', number_format($skp->nilai_perilaku, 2));
        $templateProcessor->setValue('catatan_tanggal', \Carbon\Carbon::parse($catatanPenilaian->tanggal ?? now())->format('d-m-Y'));
        $templateProcessor->setValue('catatan_uraian', $catatanPenilaian->uraian ?? '-');
        
        // Mengisi tabel kegiatan tugas jabatan
        $kegiatanTugasJabatan = $skp->kegiatan->where('jenis_kegiatan', 'tugas_jabatan')->values();
        $templateProcessor->cloneRow('no', count($kegiatanTugasJabatan));
        
        foreach ($kegiatanTugasJabatan as $index => $kegiatan) {
            $templateProcessor->setValue('no#' . ($index + 1), ($index + 1));
            $templateProcessor->setValue('kegiatan_nama#' . ($index + 1), $kegiatan->nama_kegiatan);
            $templateProcessor->setValue('kegiatan_ak#' . ($index + 1), $kegiatan->ak ?? '-');
            $templateProcessor->setValue('target_output#' . ($index + 1), $kegiatan->target_kuantitatif_output);
            $templateProcessor->setValue('target_mutu#' . ($index + 1), $kegiatan->target_kualitatif_mutu);
            $templateProcessor->setValue('target_waktu#' . ($index + 1), $kegiatan->target_waktu_bulan);
            $templateProcessor->setValue('target_biaya#' . ($index + 1), number_format($kegiatan->target_biaya, 0, ',', '.'));
            $templateProcessor->setValue('realisasi_output#' . ($index + 1), $kegiatan->realisasi_kuantitatif_output);
            $templateProcessor->setValue('realisasi_mutu#' . ($index + 1), $kegiatan->realisasi_kualitatif_mutu);
            $templateProcessor->setValue('realisasi_waktu#' . ($index + 1), $kegiatan->realisasi_waktu_bulan);
            $templateProcessor->setValue('realisasi_biaya#' . ($index + 1), number_format($kegiatan->realisasi_biaya, 0, ',', '.'));
            $templateProcessor->setValue('nilai_kegiatan#' . ($index + 1), number_format($kegiatan->nilai_kegiatan, 2));
        }
        
        // Simpan dokumen Word yang sudah diproses ke file sementara
        $fileName = 'SKP-' . ($pegawaiDinilai->nip ?? 'NIP_not_found') . '-' . $skp->tahun . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'SKP_Word');
        $templateProcessor->saveAs($tempFile);
        
        return Response::download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Mencetak SKP ke format Excel.
     */
    public function cetakExcel(SkpHeader $skp)
    {
        $skp->load(['pegawaiDinilai', 'pegawaiPenilai', 'atasanPegawaiPenilai', 'kegiatan', 'catatanPenilaian']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Contoh sederhana: tambahkan header dan data ke spreadsheet
        $sheet->setCellValue('A1', 'Kegiatan');
        $sheet->setCellValue('B1', 'Target Output');
        // ... (Tambahkan lebih banyak header) ...
        
        $row = 2;
        foreach ($skp->kegiatan as $kegiatan) {
            $sheet->setCellValue('A' . $row, $kegiatan->nama_kegiatan);
            $sheet->setCellValue('B' . $row, $kegiatan->target_kuantitatif_output);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'SKP-' . $skp->pegawaiDinilai->nip . '-' . $skp->tahun . '.xlsx';
        
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
        ];
        
        $tempFile = tempnam(sys_get_temp_dir(), 'SKP');
        $writer->save($tempFile);

        return Response::download($tempFile, $fileName, $headers)->deleteFileAfterSend(true);
    }
    /**
    * Metode privat untuk menghitung nilai per kegiatan.
    */
    private function calculateNilaiKegiatan(array $data): float
    {
        // Pastikan target tidak nol untuk menghindari pembagian oleh nol
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
        // Batasi maksimal 100
        $nilaiKuantitatif = min($nilaiKuantitatif, 100);
        
        $nilaiKualitatif = ($realisasiKualitatif / $targetKualitatif) * 100;
        // Batasi maksimal 100  
        $nilaiKualitatif = min($nilaiKualitatif, 100);
        
        // Perhitungan aspek Waktu
        if ($realisasiWaktu > $targetWaktu) {
            // Jika realisasi lebih besar, maka capaian dianggap tidak efisien.
            $nilaiWaktu = max(0, 100 - (($realisasiWaktu - $targetWaktu) / $targetWaktu) * 100);
            $nilaiWaktu = min($nilaiWaktu, 76);
        } else {
            // Jika realisasi waktu <= target waktu, hitung efisiensi
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
            // Jika realisasi lebih besar, maka capaian dianggap tidak efisien.
            $nilaiBiaya = max(0, 100 - (($realisasiBiaya - $targetBiaya) / $targetBiaya) * 100);
            $nilaiBiaya = min($nilaiBiaya, 76);
        } else {
            // Jika realisasi biaya <= target biaya, hitung efisiensi
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
        
        // Rata-rata dari 4 aspek
        return ($nilaiKuantitatif + $nilaiKualitatif + $nilaiWaktu + $nilaiBiaya) / 4;
    }

    /**
     * Metode privat untuk menentukan kategori berdasarkan nilai akhir.
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
