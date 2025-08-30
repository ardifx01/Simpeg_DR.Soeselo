<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nip',
        'nama_jabatan',
        'unit_kerja',
        'jenis_cuti',
        'alasan',
        'alasan_lainnya',
        'lama_hari',
        'tanggal_mulai',
        'tanggal_selesai',
        'alamat_cuti',
        'telepon',
        'atasan_id',
        'atasan_nama',
        'atasan_nip',
        'atasan_jabatan',
        'status'
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Relasi ke model Pegawai untuk atasan
    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }

    // Accessor untuk mendapatkan alasan lengkap
    public function getAlasanLengkapAttribute()
    {
        return $this->alasan === 'lainnya' ? $this->alasan_lainnya : $this->alasan;
    }

    // Accessor untuk status dalam bahasa Indonesia
    public function getStatusIndonesiaAttribute()
    {
        return [
            'diproses'  => 'Diproses',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
        ][$this->status] ?? 'Tidak Diketahui';
    }
    
    protected $appends = [
        'alasan_lengkap',
        'status_indonesia',
    ];
}