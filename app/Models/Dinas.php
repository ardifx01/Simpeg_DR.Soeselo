<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dinas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor',
        'sifat',
        'lampiran',
        'hal',
        'tanggal_surat',
        'tempat',
        'kepada_yth',
        'alamat_tujuan',
        'penandatangan_id',
        'tembusan'
    ];

    /**
     * Get the penandatangan associated with the SuratDinas.
     */
    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
