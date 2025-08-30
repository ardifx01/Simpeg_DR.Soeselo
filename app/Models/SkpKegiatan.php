<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model untuk tabel skp_kegiatans.
 */
class SkpKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skp_header_id',
        'jenis_kegiatan',
        'nama_kegiatan',
        'ak',
        'target_kuantitatif_output',
        'realisasi_kuantitatif_output',
        'target_kualitatif_mutu',
        'realisasi_kualitatif_mutu',
        'target_waktu_bulan',
        'realisasi_waktu_bulan',
        'target_biaya',
        'realisasi_biaya',
        'nilai_kegiatan',
    ];

    /**
     * Relasi ke model SkpHeader.
     * Setiap Kegiatan dimiliki oleh satu SKP Header.
     */
    public function skpHeader(): BelongsTo
    {
        return $this->belongsTo(SkpHeader::class, 'skp_header_id');
    }
}
