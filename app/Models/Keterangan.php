<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keterangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor',
        'pegawai_id',
        'keterangan',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'penandatangan_id',
        'tembusan',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
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
