<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'tempat_dikeluarkan',
        'tanggal_dikeluarkan',
        'dasar',
        'untuk',
        'penandatangan_id',
        'pegawai',
    ];

    protected $casts = [
        'tanggal_dikeluarkan' => 'date',
        'pegawai' => 'array',
    ];

    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
