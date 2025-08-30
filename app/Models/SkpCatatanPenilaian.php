<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model untuk tabel skp_catatan_penilaians.
 */
class SkpCatatanPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skp_header_id',
        'tanggal',
        'uraian',
        'nama_pegawai_penilai',
        'nip_pegawai_penilai',
    ];

    /**
     * Relasi ke model SkpHeader.
     * Setiap Catatan Penilaian dimiliki oleh satu SKP Header.
     */
    public function skpHeader(): BelongsTo
    {
        return $this->belongsTo(SkpHeader::class, 'skp_header_id');
    }
}
