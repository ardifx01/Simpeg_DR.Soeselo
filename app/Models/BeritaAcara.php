<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BeritaAcara extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nomor', 'hari', 'tanggal',
        'pihak_pertama_id', 'nama_pihak_pertama', 'nip_pihak_pertama', 'pangkat_pihak_pertama', 'golongan_pihak_pertama', 'jabatan_pihak_pertama', 'alamat_pihak_pertama',
        'pihak_kedua_id', 'nama_pihak_kedua', 'nip_pihak_kedua', 'pangkat_pihak_kedua', 'golongan_pihak_kedua', 'jabatan_pihak_kedua', 'alamat_pihak_kedua',
        'atasan_id', 'atasan_nama', 'atasan_nip', 'atasan_jabatan', 'pangkat_atasan', 'golongan_atasan',
    ];

    // Relasi ke model Pegawai untuk pihak pertama
    public function pihakPertama()
    {
        return $this->belongsTo(Pegawai::class, 'pihak_pertama_id');
    }

    // Relasi ke model Pegawai untuk pihak kedua
    public function pihakKedua()
    {
        return $this->belongsTo(Pegawai::class, 'pihak_kedua_id');
    }

    // Relasi ke model Pegawai untuk atasan
    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }
}
