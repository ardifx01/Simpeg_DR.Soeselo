<?php

namespace App\Services;

use DateTime;
use App\Models\Cuti;

class ValidasiCuti 
{
    private const JENIS_CUTI = [
        'tahunan' => ['limit' => 6, 'name' => 'Cuti Tahunan'],
        'melahirkan' => ['limit' => 60, 'name' => 'Cuti Melahirkan'],
        'penting' => ['limit' => 30, 'name' => 'Cuti di Luar Tanggungan Negara'],
        'sakit' => ['limit' => 14, 'name' => 'Ijin Sakit'],
    ];

    private const ALASAN_CUTI = [
        'istri_meninggal' => ['limit' => 3, 'name' => 'Istri/Suami Meninggal'],
        'orang_tua_meninggal' => ['limit' => 2, 'name' => 'Orang Tua/Mertua Meninggal'],
        'istri_melahirkan' => ['limit' => 2, 'name' => 'Istri Melahirkan'],
        'saudara_meninggal' => ['limit' => 2, 'name' => 'Saudara Kandung Meninggal'],
        'keluarga_sakit' => ['limit' => 2, 'name' => 'Istri/Suami/Anak Sakit Keras'],
        'musibah' => ['limit' => 2, 'name' => 'Musibah (Kebakaran/Banjir/Bencana Alam)'],
        'menikah' => ['limit' => 6, 'name' => 'Pegawai Menikah'],
        'anak_menikah' => ['limit' => 2, 'name' => 'Pernikahan Anak'],
        'saudara_menikah' => ['limit' => 1, 'name' => 'Pernikahan Saudara Kandung'],
        'khitan_anak' => ['limit' => 2, 'name' => 'Khitan/Baptis Anak'],
        'haji' => ['limit' => 36, 'name' => 'Ibadah Haji'], // Update batas menjadi 36 hari
        'ibadah_lainnya' => ['limit' => 30, 'name' => 'Ibadah Lainnya'],
        'panggilan_dinas' => ['limit' => -1, 'name' => 'Panggilan Dinas'],
        'pemilu' => ['limit' => 1, 'name' => 'Pelaksanaan Pemilu'],
        'seminar' => ['limit' => 5, 'name' => 'Training/Seminar/Lokakarya'],
        'lainnya' => ['limit' => 2, 'name' => 'Alasan Lainnya']
    ];

    private $cutiTerpakai = [];

    public function __construct() 
    {
        $this->initializeCutiTerpakai();
    }

    private function initializeCutiTerpakai() 
    {
        // Inisialisasi cuti terpakai berdasarkan jenis cuti
        foreach (self::JENIS_CUTI as $jenis => $data) {
            $this->cutiTerpakai[$jenis] = $this->hitungCutiTerpakaiTahunIni($jenis);
        }

        // Inisialisasi cuti terpakai berdasarkan alasan
        foreach (self::ALASAN_CUTI as $alasan => $data) {
            $this->cutiTerpakai['alasan_' . $alasan] = $this->hitungCutiTerpakaiTahunIni(null, $alasan);
        }
    }

    private function hitungCutiTerpakaiTahunIni($jenisCuti = null, $alasan = null) 
    {
        $tahunIni = date('Y');
        $query = Cuti::whereYear('tanggal_mulai', $tahunIni);
        
        if ($jenisCuti) {
            $query->where('jenis_cuti', $jenisCuti);
        }
        
        if ($alasan) {
            $query->where('alasan', $alasan);
        }

        return $query->sum('lama_hari');
    }

    public function validasiPengajuanCuti($jenisCuti, $alasan, $tanggalMulai, $tanggalSelesai) 
    {
        $hariDiminta = $this->hitungHari($tanggalMulai, $tanggalSelesai);
        
        // Validasi berdasarkan jenis cuti
        $detailJenisCuti = self::JENIS_CUTI[$jenisCuti] ?? null;
        if (!$detailJenisCuti) {
            return [
                'valid' => false,
                'message' => 'Jenis cuti tidak valid'
            ];
        }

        // Validasi khusus untuk Haji
        if ($alasan === 'haji') {
            return $this->validasiCutiHaji($tanggalMulai, $tanggalSelesai);
        }

        // Validasi berdasarkan alasan
        $detailAlasanCuti = self::ALASAN_CUTI[$alasan] ?? null;
        if ($detailAlasanCuti) {
            if ($detailAlasanCuti['limit'] !== -1) {
                $sisaHariAlasan = $detailAlasanCuti['limit'] - $this->cutiTerpakai['alasan_' . $alasan];
                if ($hariDiminta > $sisaHariAlasan) {
                    return [
                        'valid' => false,
                        'message' => "Anda telah melebihi batas maksimal untuk {$detailAlasanCuti['name']}. Sisa: {$sisaHariAlasan} hari"
                    ];
                }
            }
        }

        // Validasi batas jenis cuti
        if ($detailJenisCuti['limit'] !== -1) {
            $sisaHariJenis = $detailJenisCuti['limit'] - $this->cutiTerpakai[$jenisCuti];
            if ($hariDiminta > $sisaHariJenis) {
                return [
                    'valid' => false,
                    'message' => "Anda telah melebihi batas maksimal {$detailJenisCuti['name']} tahun ini. Sisa: {$sisaHariJenis} hari"
                ];
            }
        }

        return [
            'valid' => true,
            'message' => 'Pengajuan cuti valid'
        ];
    }

    private function hitungHari($tanggalMulai, $tanggalSelesai) 
    {
        $mulai = new DateTime($tanggalMulai);
        $selesai = new DateTime($tanggalSelesai);
        $interval = $mulai->diff($selesai);
        return $interval->days + 1;
    }

    private function validasiCutiHaji($tanggalMulai, $tanggalSelesai) 
    {
        $hariDiminta = $this->hitungHari($tanggalMulai, $tanggalSelesai);
        $batasHariHaji = self::ALASAN_CUTI['haji']['limit'];
        
        if ($hariDiminta > $batasHariHaji) {
            return [
                'valid' => false,
                'message' => "Cuti Haji tidak boleh melebihi {$batasHariHaji} hari"
            ];
        }

        if ($hariDiminta < 6) { // Minimal 3 hari sebelum dan 3 hari sesudah
            return [
                'valid' => false,
                'message' => 'Cuti Haji minimal harus mencakup 3 hari sebelum dan 3 hari sesudah pelaksanaan'
            ];
        }

        // Cek apakah sudah pernah mengambil cuti haji tahun ini
        $cutiHajiTerpakai = $this->cutiTerpakai['alasan_haji'];
        if ($cutiHajiTerpakai > 0) {
            return [
                'valid' => false,
                'message' => 'Anda sudah mengambil cuti Haji tahun ini'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Pengajuan cuti Haji valid'
        ];
    }

    public function updateCutiTerpakai($jenisCuti, $alasan, $hari) 
    {
        if (isset($this->cutiTerpakai[$jenisCuti])) {
            $this->cutiTerpakai[$jenisCuti] += $hari;
        }
        if (isset($this->cutiTerpakai['alasan_' . $alasan])) {
            $this->cutiTerpakai['alasan_' . $alasan] += $hari;
        }
    }

    public static function getDaftarJenisCuti()
    {
        return self::JENIS_CUTI;
    }

    public static function getDaftarAlasanCuti()
    {
        return self::ALASAN_CUTI;
    }
}