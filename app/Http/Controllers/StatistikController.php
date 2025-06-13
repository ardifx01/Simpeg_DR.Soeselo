<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\StatisticsService;

class StatistikController extends Controller
{
    /**
     * Mendapatkan daftar unit kerja.
     *
     * @return array
     */
    private function getUnitKerjaOptions(): array
    {
        return [
            'Direktur RSUD dr Soeselo',
            'Wakil Direktur Pelayanan',
            'Kepala Bidang Pelayanan Medis',
            'Dokter Ahli Utama',
            'Dokter Ahli Madya',
            'Dokter Ahli Muda',
            'Dokter Ahli Pertama',
            'Dokter Gigi Ahli Madya',
            'Penata Kelola Layanan Kesehatan',
            'Pengadministrasi Perkantoran',
            'Kepala Bidang Pelayanan Keperawatan',
            'Perawat Ahli Madya',
            'Perawat Ahli Muda',
            'Perawat Ahli Pertama',
            'Perawat Penyelia',
            'Perawat Mahir',
            'Perawat Terampil',
            'Terapis Gigi dan Mulut Mahir',
            'Terapis Gigi dan Mulut Terampil',
            'Bidan Ahli Madya',
            'Bidan Ahli Muda',
            'Bidan Ahli Pertama',
            'Bidan Penyelia',
            'Bidan Mahir',
            'Bidan Terampil',
            'Penata Kelola Layanan Kesehatan',
            'Pengelola Layanan Kesehatan',
            'Pengadministrasi Perkantoran',
            'Operator Layanan Operasional',
            'Kepala Bidang Pelayanan Penunjang',
            'Administrator Kesehatan Ahli Muda',
            'Administrator Kesehatan Ahli Pertama',
            'Apoteker Ahli Utama',
            'Apoteker Ahli Madya',
            'Apoteker Ahli Pertama',
            'Asisten Apoteker Penyelia',
            'Asisten Apoteker Terampil',
            'Nutrisionis Ahli Madya',
            'Nutrisionis Ahli Pertama',
            'Nutrisionis Penyelia',
            'Radiografer Ahli Madya',
            'Radiografer Ahli Muda',
            'Radiografer Ahli Pertama',
            'Radiografer Penyelia',
            'Radiografer Terampil',
            'Pranata Laboratorium Kesehatan Ahli Madya',
            'Pranata Laboratorium Kesehatan Ahli Muda',
            'Pranata Laboratorium Kesehatan Penyelia',
            'Pranata Laboratorium Kesehatan Mahir',
            'Pranata Laboratorium Kesehatan Terampil',
            'Fisioterapis Ahli Madya',
            'Fisioterapis Ahli Muda',
            'Fisioterapis Ahli Pertama',
            'Fisioterapis Penyelia',
            'Fisioterapis Terampil',
            'Refraksionis Optisien Penyelia',
            'Refraksionis Optisien Mahir',
            'Perekam Medis Penyelia',
            'Perekam Medis Mahir',
            'Perekam Medis Terampil',
            'Okupasi Terapis Mahir',
            'Okupasi Terapis Terampil',
            'Penata Anestesi Ahli Madya',
            'Penata Anestesi Ahli Muda',
            'Penata Anestesi Ahli Pertama',
            'Asisten Penata Anestesi Penyelia',
            'Asisten Penata Anestesi Terampil',
            'Psikolog Klinis Ahli Pertama',
            'Tenaga Sanitasi Lingkungan Ahli Madya',
            'Tenaga Sanitasi Lingkungan Ahli Muda',
            'Tenaga Sanitasi Lingkungan Ahli Pertama',
            'Tenaga Sanitasi Lingkungan Terampil',
            'Teknisi Elektromedis Ahli Pertama',
            'Teknisi Elektromedis Penyelia',
            'Teknisi Elektromedis Mahir',
            'Teknisi Elektromedis Terampil',
            'Fisikawan Medis Ahli Pertama',
            'Pembimbing Kesehatan Kerja Ahli Pertama',
            'Teknisi Transfusi Darah Terampil',
            'Terapis Wicara Mahir',
            'Terapis Wicara Terampil',
            'Ortotis Prostetis Terampil',
            'Penata Kelola Layanan Kesehatan',
            'Pengelola Layanan Operasional',
            'Operator Layanan Kesehatan',
            'Pengadministrasi Perkantoran',
            'Pengelola Umum Operasional',
            'Wakil Direktur Umum dan Keuangan',
            'Kepala Bagian Tata Usaha',
            'Kepala Subbagian Umum',
            'Pranata Komputer Ahli Pertama',
            'Penyuluh Kesehatan Masyarakat Ahli Pertama',
            'Pranata Komputer Terampil',
            'Arsiparis Terampil',
            'Penelaah Teknis Kebijakan',
            'Penata Layanan Operasional',
            'Pengelola Layanan Operasional',
            'Pengolah Data dan Informasi',
            'Dokumentalis Hukum',
            'Pengadministrasi Perkantoran',
            'Operator Layanan Operasiona',
            'Kepala Subbagian Kepegawaian',
            'Penata Layanan Operasional',
            'Pengelola Layanan Operasional',
            'Operator Layanan Operasional',
            'Pengadministrasi Perkantoran',
            'Kepala Bagian Keuangan',
            'Analis Keuangan Pusat dan Daerah Ahli Muda',
            'Analis Keuangan Pusat dan Daerah Ahli Pertama',
            'Penelaah Teknis Kebijakan',
            'Fasilitator Pemerintahan',
            'Pengolah Data dan Informasi',
            'Operator Layanan Operasional',
            'Kepala Bagian Perencanaan',
            'Perencana Ahli Pertama',
            'Penelaah Teknis Kebijakan',
            'Pengadministrasi Perkantoran',
        ];
    }
    
    /**
     * Mendapatkan daftar kategori statistik.
     *
     * @return array
     */
    private function getKategoriOptions(): array
    {
        return [
            'pendidikan' => 'Pendidikan Formal',
            'unitkerja_pendidikan' => 'Unit Kerja dan Pendidikan',
            'unitkerja_golongan' => 'Unit Kerja dan Golongan',
            'jk_golongan' => 'Jenis Kelamin dan Golongan',
            'jk_eselon' => 'Jenis Kelamin dan Eselon',
            'eselon_golongan' => 'Eselon dan Golongan',
            'status_pegawai' => 'Status Kedudukan Pegawai',
            'diklat' => 'Diklat Struktural',
            'agama_golongan' => 'Agama dan Golongan'
        ];
    }
    protected $statisticsService;
    
    /**
     * Konstruktor untuk dependency injection.
     * 
     * @param StatisticsService $statisticsService
     */
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }
    /**
     * Menampilkan halaman statistik pegawai.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $unitKerja = $this->getUnitKerjaOptions();
        $kategoriOptions = $this->getKategoriOptions();
        
        $selectedUnitKerja = $request->input('unit_kerja', 'RSUD dr. Soeselo Slawi');
        $selectedKategori = $request->input('kategori');
        
        $dataStatistik = [];
        $judulKolomPertama = '';
        
        if ($selectedKategori) {
            $result = $this->statisticsService->generateStatistics(
                $selectedKategori, 
                $selectedUnitKerja
            );
            
            $dataStatistik = $result['dataStatistik'];
            $judulKolomPertama = $result['judulKolomPertama'];
        }
        
        return view('dashboard.statistik.index', compact(
            'unitKerja',
            'kategoriOptions',
            'selectedKategori',
            'dataStatistik',
            'judulKolomPertama',
            'selectedUnitKerja'
        ));
    }

    /**
     * Cetak statistik dalam format PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function cetak(Request $request)
    {
        $selectedUnitKerja = $request->input('unit_kerja', 'RSUD dr. Soeselo Slawi');
        $selectedKategori = $request->input('kategori');
        
        // Validasi kategori
        if (!$selectedKategori) {
            return redirect()->back()->with('error', 'Pilih kategori terlebih dahulu');
        }

        // Generate statistik
        $result = $this->statisticsService->generateStatistics(
            $selectedKategori, 
            $selectedUnitKerja
        );
        
        // Validasi hasil
        if (empty($result['dataStatistik'])) {
            return redirect()->back()->with('error', 'Data statistik tidak tersedia untuk kategori yang dipilih');
        }

        // Tentukan judul berdasarkan kategori
        $judulMap = [
            'pendidikan' => 'PENDIDIKAN FORMAL',
            'unitkerja_pendidikan' => 'UNIT KERJA BERDASARKAN PENDIDIKAN',
            'unitkerja_golongan' => 'UNIT KERJA BERDASARKAN GOLONGAN',
            'diklat' => 'DIKLAT STRUKTURAL',
            'jk_eselon' => 'JENIS KELAMIN BERDASARKAN ESELON',
            'jk_golongan' => 'JENIS KELAMIN BERDASARKAN GOLONGAN',
            'eselon_golongan' => 'ESELON BERDASARKAN GOLONGAN',
            'agama_golongan' => 'AGAMA BERDASARKAN GOLONGAN',
            'status_pegawai' => 'STATUS BERDASARKAN GOLONGAN',
            'usia_golongan' => 'USIA BERDASARKAN GOLONGAN'
        ];

        $judulKolomPertama = $result['judulKolomPertama'] ?? ($judulMap[$selectedKategori] ?? strtoupper($selectedKategori));
        
        $title = "STATISTIK PEGAWAI BERDASARKAN {$judulKolomPertama} PADA RSUD DR. SOESELO SLAWI";
        
        // Unit kerja info untuk judul
        $unitKerjaInfo = '';
        if ($selectedUnitKerja && $selectedUnitKerja !== 'RSUD dr. Soeselo Slawi') {
            $unitKerjaInfo = " - {$selectedUnitKerja}";
            $title .= $unitKerjaInfo;
        }

        $data = [
            'title' => $title,
            'judulKolomPertama' => $judulKolomPertama,
            'kategori' => $selectedKategori,
            'dataStatistik' => $result['dataStatistik'],
            'golonganColumns' => $result['golonganColumns'] ?? [],
            'eselonColumns' => $result['eselonColumns'] ?? [],
            'unitKerja' => $selectedUnitKerja
        ];

        // Set paper size berdasarkan kategori
        $paperSize = 'a4';
        $orientation = 'landscape';
        
        // Untuk kategori dengan banyak kolom, gunakan paper yang lebih besar
        if ($selectedKategori === 'diklat') {
            $paperSize = 'a3';
        }

        $pdf = Pdf::loadView('dashboard.statistik.cetak_pdf', $data)
                ->setPaper($paperSize, $orientation)
                ->setOptions([
                    'margin-top' => 5,
                    'margin-right' => 5,
                    'margin-bottom' => 5,
                    'margin-left' => 5,
                ]);

        // Generate filename
        $filename = 'statistik_' . $selectedKategori;
        if ($selectedUnitKerja && $selectedUnitKerja !== 'RSUD dr. Soeselo Slawi') {
            $filename .= '_' . str_replace(' ', '_', strtolower($selectedUnitKerja));
        }
        $filename .= '_' . now()->format('dmY_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Preview PDF sebelum download
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function preview(Request $request)
    {
        $selectedUnitKerja = $request->input('unit_kerja') ?: null;
        $selectedKategori = $request->input('kategori');
        
        $result = $this->statisticsService->generateStatistics(
            $selectedKategori, 
            $selectedUnitKerja
        );
        
        if (empty($result['dataStatistik'])) {
            return redirect()->back()->with('error', 'Data statistik tidak tersedia');
        }

        $judulMap = [
            'pendidikan' => 'PENDIDIKAN FORMAL',
            'unitkerja_pendidikan' => 'UNIT KERJA BERDASARKAN PENDIDIKAN',
            'unitkerja_golongan' => 'UNIT KERJA BERDASARKAN GOLONGAN',
            'diklat' => 'DIKLAT STRUKTURAL',
            'jk_eselon' => 'JENIS KELAMIN BERDASARKAN ESELON',
            'jk_golongan' => 'JENIS KELAMIN BERDASARKAN GOLONGAN',
            'eselon_golongan' => 'ESELON BERDASARKAN GOLONGAN',
            'agama_golongan' => 'AGAMA BERDASARKAN GOLONGAN',
            'status_pegawai' => 'STATUS BERDASARKAN GOLONGAN',
            'usia_golongan' => 'USIA BERDASARKAN GOLONGAN'
        ];

        $judulKolomPertama = $result['judulKolomPertama'] ?? ($judulMap[$selectedKategori] ?? strtoupper($selectedKategori));
        $title = "STATISTIK PEGAWAI BERDASARKAN {$judulKolomPertama} PADA RSUD DR. SOESELO SLAWI";

        $data = [
            'title' => $title,
            'judulKolomPertama' => $judulKolomPertama,
            'kategori' => $selectedKategori,
            'dataStatistik' => $result['dataStatistik'],
            'golonganColumns' => $result['golonganColumns'] ?? [],
            'eselonColumns' => $result['eselonColumns'] ?? [],
            'unitKerja' => $selectedUnitKerja
        ];

        $paperSize = $selectedKategori === 'diklat' ? 'a3' : 'a4';
        
        $pdf = Pdf::loadView('dashboard.statistik.cetak_pdf', $data)
                ->setPaper($paperSize, 'landscape');

        return $pdf->stream('preview_statistik.pdf');
    }
}