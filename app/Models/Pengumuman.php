<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nomor_surat',
        'tentang',
        'isi_pengumuman',
        'dikeluarkan_di',
        'tanggal_dikeluarkan',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
