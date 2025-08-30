<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Panggilan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'penandatangan_id',
        'nomor_surat',
        'sifat',
        'lampiran',
        'tanggal_surat',
        'perihal',
        'jadwal_hari',
        'jadwal_tanggal',
        'jadwal_pukul',
        'jadwal_tempat',
        'menghadap_kepada',
        'alamat_menghadap',
        'tembusan',
    ];

    protected $casts = [
        'tembusan'        => 'array',
        'tanggal_surat'   => 'date',
        'jadwal_tanggal'  => 'date',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Pejabat yang menandatangani
    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
