<?php

namespace App\Services;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Collection;

class StatisticsService
{
    /**
     * Data golongan yang digunakan dalam perhitungan statistik.
     *
     * @var array
     */
    protected array $golonganColumns = [
        'kosong', 'Ia', 'Ib', 'Ic', 'Id', 
        'IIa', 'IIb', 'IIc', 'IId', 
        'IIIa', 'IIIb', 'IIIc', 'IIId', 
        'IVa', 'IVb', 'IVc', 'IVd', 'IVe', 'X'
    ];
    
    /**
     * Generate statistik berdasarkan kategori yang dipilih.
     *
     * @param string $kategori
     * @param string|null $unitKerja
     * @return array
     */
    public function generateStatistics(string $kategori, ?string $unitKerja = null): array
    {

        $method = 'calculate' . ucfirst($kategori) . 'Statistics';
        
        if (method_exists($this, $method)) {
            $result = $this->$method($unitKerja);            
            return $result;
        }
        
        return [
            'dataStatistik' => [],
            'judulKolomPertama' => ''
        ];
    }
    
    /**
     * Mendapatkan data pegawai berdasarkan filter unit kerja.
     *
     * @param string|null $unitKerja
     * @return Collection
     */
    protected function getPegawaiData(?string $unitKerja = null): Collection
    {
        $query = Pegawai::query();
        
        if ($unitKerja) {
            $query->whereHas('jabatan', function ($q) use ($unitKerja) {
                $q->where('unit_kerja', $unitKerja);
            });
        } else {
            $query->whereHas('jabatan');
        }
        
        $result = $query->with(['pendidikans', 'jabatan'])->get();
        
        return $result;
    }
    
    /**
     * Inisialisasi struktur data statistik.
     *
     * @param array $categories
     * @return array
     */
    protected function initializeStatisticStructure(array $categories): array
    {
        $structure = [];
        
        foreach ($categories as $category) {
            $structure[$category] = array_merge(
                ['total' => 0],
                array_fill_keys($this->golonganColumns, 0)
            );
        }
        
        // Tambahkan baris total
        $structure['TOTAL'] = array_merge(
            ['total' => 0],
            array_fill_keys($this->golonganColumns, 0)
        );
        
        return $structure;
    }

    /**
     * Helper method to validate and process pegawai data
     *
     * @param Collection $pegawai
     * @return bool
     */
    protected function validatePegawaiData(Collection $pegawai): bool
    {
        $valid = $pegawai->isNotEmpty();
        
        return $valid;
    }
    
    /**
     * Menghitung statistik berdasarkan pendidikan formal.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculatePendidikanStatistics(?string $unitKerja = null): array
    {
        $tingkat = ['SD', 'SMP', 'SMA', 'D3', 'D4', 'S1', 'S2', 'S3'];
        $dataStatistik = $this->initializeStatisticStructure($tingkat);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $pendidikanTerakhir = $pegawai->pendidikans()->latest('tingkat')->first();
            
            // Langsung ambil nilai tingkat tanpa normalisasi
            $pendidikanLabel = $pendidikanTerakhir?->tingkat ?? 'Belum Menambahkan Pendidikan';
            
            if (!in_array($pendidikanLabel, $tingkat)) {
                continue;
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung statistik
            $dataStatistik[$pendidikanLabel]['total'] = ($dataStatistik[$pendidikanLabel]['total'] ?? 0) + 1;
            $dataStatistik[$pendidikanLabel][$gol] = ($dataStatistik[$pendidikanLabel][$gol] ?? 0) + 1;
            
            $dataStatistik['TOTAL']['total'] = ($dataStatistik['TOTAL']['total'] ?? 0) + 1;
            $dataStatistik['TOTAL'][$gol] = ($dataStatistik['TOTAL'][$gol] ?? 0) + 1;
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'PENDIDIKAN FORMAL'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan unit kerja dan pendidikan.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateUnitkerja_pendidikanStatistics(?string $unitKerja = null): array
    {
        $daftarUnitKerja = $this->getUnitKerjaList();
        $dataStatistik = $this->initializeStatisticStructure($daftarUnitKerja);
        $tingkatPendidikan = ['SD', 'SMP', 'SMA', 'D3', 'D4', 'S1', 'S2', 'S3'];
        
        // Inisialisasi struktur untuk setiap tingkat pendidikan
        foreach ($daftarUnitKerja as $unit) {
            $dataStatistik[$unit] = array_merge(
                ['total' => 0, 'kosong' => 0],
                array_fill_keys($tingkatPendidikan, 0)
            );
        }
        
        // Tambah baris total
        $dataStatistik['TOTAL'] = array_merge(
            ['total' => 0, 'kosong' => 0],
            array_fill_keys($tingkatPendidikan, 0)
        );
        
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $unitKerjaPegawai = $pegawai->jabatan?->unit_kerja ?? 'Tidak Diketahui';
            
            if (!isset($dataStatistik[$unitKerjaPegawai])) {
                continue; // Skip jika unit kerja tidak terdaftar
            }
            
            $pendidikanTerakhir = $pegawai->pendidikans()->orderByDesc('tingkat')->first();
            $tingkat = $pendidikanTerakhir?->tingkat ?? null;
            
            // Mendapatkan golongan ruang pegawai
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : null;
            
            // Hanya proses tingkat yang ada dalam daftar
            if (in_array($tingkat, $tingkatPendidikan)) {
                // Hitung untuk unit kerja tersebut
                $dataStatistik[$unitKerjaPegawai]['total']++;
                $dataStatistik[$unitKerjaPegawai][$tingkat]++;
                
                // Update total
                $dataStatistik['TOTAL']['total']++;
                $dataStatistik['TOTAL'][$tingkat]++;
            } elseif (!$gol) { // FIX: Perbaiki syntax error
                $dataStatistik[$unitKerjaPegawai]['kosong']++;
                $dataStatistik['TOTAL']['kosong']++;
            } else {
                // Tetap hitung total meskipun tingkat tidak diketahui
                $dataStatistik[$unitKerjaPegawai]['total']++;
                $dataStatistik['TOTAL']['total']++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'UNIT KERJA'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan unit kerja dan golongan.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateUnitkerja_golonganStatistics(?string $unitKerja = null): array
    {
        $daftarUnitKerja = $this->getUnitKerjaList();
        $dataStatistik = $this->initializeStatisticStructure($daftarUnitKerja);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $unitKerjaPegawai = $pegawai->jabatan?->unit_kerja ?? 'Tidak Diketahui';
            
            if (!isset($dataStatistik[$unitKerjaPegawai])) {
                continue;
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung untuk unit kerja
            $dataStatistik[$unitKerjaPegawai]['total']++;
            $dataStatistik['TOTAL']['total']++;
            
            // Hitung untuk golongan
            if (isset($dataStatistik[$unitKerjaPegawai][$gol])) {
                $dataStatistik[$unitKerjaPegawai][$gol]++;
                $dataStatistik['TOTAL'][$gol]++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'UNIT KERJA'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan jenis kelamin dan golongan.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateJk_golonganStatistics(?string $unitKerja = null): array
    {
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $dataStatistik = $this->initializeStatisticStructure($jenisKelamin);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $jk = $pegawai->jenis_kelamin ?? 'Tidak Diketahui';
            
            if (!in_array($jk, $jenisKelamin)) {
                continue;
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung untuk jenis kelamin
            $dataStatistik[$jk]['total']++;
            $dataStatistik['TOTAL']['total']++;
            
            // Hitung untuk golongan
            if (isset($dataStatistik[$jk][$gol])) {
                $dataStatistik[$jk][$gol]++;
                $dataStatistik['TOTAL'][$gol]++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'JENIS KELAMIN'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan status kedudukan pegawai.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateStatus_pegawaiStatistics(?string $unitKerja = null): array
    {
        $status = [
            'Aktif', 'CLTN', 'Tugas Belajar', 'Pemberhentian sementara', 'Penerima Uang Tunggu', 
            'Wajib Militer', 'Pejabat Negara', 'Kepala Desa', 'Proses Banding BAPEK', 'Masa Persiapan Pensiun',
            'Pensiun', 'Calon CPNS', 'Kepala Desa', 'Proses Banding BAPEK'
        ];
        $dataStatistik = $this->initializeStatisticStructure($status);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $pegawaiStatus = $pegawai->jabatan()->orderByDesc('status')->first();
            $statusLabel = $pegawaiStatus?->status ?? 'Belum Menambahkan Status';
            
            if (!in_array($statusLabel, $status)) {
                continue; // Skip data yang tidak sesuai kategori
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung untuk kategori status
            $dataStatistik[$statusLabel]['total']++;
            $dataStatistik['TOTAL']['total']++;
            
            // Hitung berdasarkan golongan
            if (isset($dataStatistik[$statusLabel][$gol])) {
                $dataStatistik[$statusLabel][$gol]++;
                $dataStatistik['TOTAL'][$gol]++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'STATUS KEDUDUKAN'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan diklat struktural. error
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateDiklatStatistics(?string $unitKerja = null): array
    {
        $kategoriDiklat = ['Fungsional', 'Jabatan', 'Teknis'];
        $eselonColumns = ['I.a', 'I.b', 'II.a', 'II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'V.a', 'V.b', '-'];

        // Inisialisasi struktur data
        $dataStatistik = [];
        
        // Buat semua kategori diklat dengan struktur lengkap
        foreach ($kategoriDiklat as $kategori) {
            $dataStatistik[$kategori] = array_merge(
                array_fill_keys($eselonColumns, 0),
                ['total' => 0, 'kosong' => 0],
                array_fill_keys($this->golonganColumns, 0)
            );
        }

        // Inisialisasi TOTAL
        $dataStatistik['TOTAL'] = array_merge(
            array_fill_keys($eselonColumns, 0),
            ['total' => 0, 'kosong' => 0],
            array_fill_keys($this->golonganColumns, 0)
        );

        $pegawais = $this->getPegawaiData($unitKerja);

        foreach ($pegawais as $pegawai) {
            $eselonLabel = optional($pegawai->jabatan)->eselon ?? '-';
            $golonganLabel = $pegawai->golongan_ruang ? str_replace('/', '', $pegawai->golongan_ruang) : 'X';

            // Normalisasi label
            $eselonLabel = in_array($eselonLabel, $eselonColumns) ? $eselonLabel : '-';
            $golonganLabel = in_array($golonganLabel, $this->golonganColumns) ? $golonganLabel : 'X';

            foreach ($kategoriDiklat as $kategori) {
                // Tentukan relasi berdasarkan kategori
                $relasi = match ($kategori) {
                    'Fungsional' => 'diklat_fungsionals',
                    'Jabatan' => 'diklat_jabatans',
                    'Teknis' => 'diklat_tekniks',
                    default => null
                };

                if (!$relasi) {
                    continue;
                }

                // Hitung jumlah diklat untuk pegawai ini
                $jumlahDiklat = $pegawai->$relasi()->count();

                // Update statistik berdasarkan apakah pegawai memiliki diklat atau tidak
                if ($jumlahDiklat > 0) {
                    // Pegawai memiliki diklat - hitung 1 pegawai (bukan jumlah diklat)
                    $dataStatistik[$kategori][$eselonLabel] += 1;
                    $dataStatistik[$kategori][$golonganLabel] += 1;
                    $dataStatistik[$kategori]['total'] += 1;
                    
                    // Update TOTAL
                    $dataStatistik['TOTAL'][$eselonLabel] += 1;
                    $dataStatistik['TOTAL'][$golonganLabel] += 1;
                    $dataStatistik['TOTAL']['total'] += 1;
                } else {
                    // Pegawai tidak memiliki diklat - hitung sebagai kosong
                    $dataStatistik[$kategori]['kosong'] += 1;
                    $dataStatistik['TOTAL']['kosong'] += 1;
                }
            }
        }

        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'DIKLAT STRUKTURAL',
            'golonganColumns' => $this->golonganColumns,
            'eselonColumns' => $eselonColumns,
        ];
    }

    /**
     * Menghitung statistik berdasarkan eselon dan golongan.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateEselon_golonganStatistics(?string $unitKerja = null): array
    {
        $eselons = ['I.a', 'I.b', 'II.a', 'II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'V', 'Non Eselon'];
        $dataStatistik = $this->initializeStatisticStructure($eselons);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $eselon = $pegawai->eselon ?? 'Non Eselon';
            
            if (!in_array($eselon, $eselons)) {
                $eselon = 'Non Eselon';
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung untuk eselon
            $dataStatistik[$eselon]['total']++;
            $dataStatistik['TOTAL']['total']++;
            
            // Hitung untuk golongan
            if (isset($dataStatistik[$eselon][$gol])) {
                $dataStatistik[$eselon][$gol]++;
                $dataStatistik['TOTAL'][$gol]++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'ESELON'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan jenis kelamin dan eselon.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateJk_eselonStatistics(?string $unitKerja = null): array
    {
        $jenisKelamin = ['Laki-laki', 'Perempuan'];
        $eselons = ['I.a', 'I.b', 'II.a', 'II.b', 'III.a', 'III.b', 'IV.a', 'IV.b', 'V.a', 'V.b'];
        
        $dataStatistik = [];
        
        // Initialize data structure
        foreach ($jenisKelamin as $jk) {
            $dataStatistik[$jk] = array_merge(
                ['total' => 0, 'kosong' => 0], // 'kosong' counts employees without eselon
                array_fill_keys($eselons, 0)
            );
        }
        
        $dataStatistik['TOTAL'] = array_merge(
            ['total' => 0, 'kosong' => 0],
            array_fill_keys($eselons, 0)
        );
        
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $jk = $pegawai->jenis_kelamin ?? 'Tidak Diketahui';
            
            if (!in_array($jk, $jenisKelamin)) {
                continue;
            }
            
            $eselon = $pegawai->eselon ?? null;
            
            // Count employees without eselon
            if (empty($eselon) || $eselon === '') {
                $dataStatistik[$jk]['kosong']++;
                $dataStatistik[$jk]['total']++;
                $dataStatistik['TOTAL']['kosong']++;
                $dataStatistik['TOTAL']['total']++;
                continue;
            }
            
            // Validate eselon format
            if (!in_array($eselon, $eselons)) {
                $eselon = 'kosong';
            }
            
            // Count for gender
            $dataStatistik[$jk]['total']++;
            $dataStatistik[$jk][$eselon]++;
            
            // Update total
            $dataStatistik['TOTAL']['total']++;
            $dataStatistik['TOTAL'][$eselon]++;
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'JENIS KELAMIN'
        ];
    }
    
    /**
     * Menghitung statistik berdasarkan agama dan golongan.
     *
     * @param string|null $unitKerja
     * @return array
     */
    protected function calculateAgama_golonganStatistics(?string $unitKerja = null): array
    {
        $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
        $dataStatistik = $this->initializeStatisticStructure($agama);
        $pegawais = $this->getPegawaiData($unitKerja);
        
        foreach ($pegawais as $pegawai) {
            $agamaPegawai = $pegawai->agama ?? 'Lainnya';
            
            if (!in_array($agamaPegawai, $agama)) {
                $agamaPegawai = 'Lainnya';
            }
            
            $golongan = $pegawai->golongan_ruang;
            $gol = $golongan ? str_replace('/', '', $golongan) : 'kosong';
            
            // Hitung untuk agama
            $dataStatistik[$agamaPegawai]['total']++;
            $dataStatistik['TOTAL']['total']++;
            
            // Hitung untuk golongan
            if (isset($dataStatistik[$agamaPegawai][$gol])) {
                $dataStatistik[$agamaPegawai][$gol]++;
                $dataStatistik['TOTAL'][$gol]++;
            }
        }
        
        return [
            'dataStatistik' => $dataStatistik,
            'judulKolomPertama' => 'AGAMA'
        ];
    }
    
    /**
     * Mendapatkan daftar unit kerja yang tersedia.
     *
     * @return array
     */
    protected function getUnitKerjaList(): array
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
}