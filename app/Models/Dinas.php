<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dinas extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'dinas';

    // Kolom yang dapat diisi secara massal
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
