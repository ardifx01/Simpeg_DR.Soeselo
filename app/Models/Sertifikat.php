<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor',
        'penerima_id',
        'instansi',
        'nama_kegiatan',
        'penyelenggara',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'tempat_terbit',
        'tanggal_terbit',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_terbit'  => 'date',
    ];

    public function penerima()
    {
        return $this->belongsTo(Pegawai::class, 'penerima_id');
    }

    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
