<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengantar extends Model
{
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tujuan',
        'alamat_tujuan',
        'daftar_item',
        'penerima_id',
        'pengirim_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'daftar_item'   => 'array',
    ];

    public function penerima()
    {
        return $this->belongsTo(Pegawai::class, 'penerima_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pegawai::class, 'pengirim_id');
    }
}
