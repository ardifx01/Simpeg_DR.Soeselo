<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perintah extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'nomor_surat',
        'tanggal_perintah',
        'tempat_dikeluarkan',
        'menimbang',
        'dasar',
        'untuk',
        'penerima',
    ];

    protected $casts = [
        'tanggal_perintah' => 'date',
        'penerima'         => 'array',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
