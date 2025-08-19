<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class notaDinas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor', 'sifat', 'tanggal', 'sifat',
        'pemberi_id', 'penerima_id', 'lampiran',
        'keperluan', 'tembusan', 'hal', 'isi',
    ];

    protected $casts = [
        'tanggal'  => 'date',
        'tembusan' => 'array',
    ];

    public function pemberi()
    {
        return $this->belongsTo(Pegawai::class, 'pemberi_id');
    }

    // Relasi ke model Pegawai untuk atasan
    public function penerima()
    {
        return $this->belongsTo(Pegawai::class, 'penerima_id');
    }
}
