<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'pegawai_id', 'jenis_cuti', 'alasan', 'alasan_lainnya', 'lama_hari',
        'tanggal_mulai', 'tanggal_selesai', 'alamat_cuti', 'telepon', 'atasan_jabatan',
        'atasan_id', 'atasan_nama', 'atasan_nip', 'status'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }
}
