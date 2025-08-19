<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panggilan extends Model
{
    use HasFactory;

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

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
