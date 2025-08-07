<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model untuk tabel skp_headers.
 */
class SkpHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_dinilai_id',
        'pegawai_penilai_id',
        'atasan_pegawai_penilai_id',
        'tahun',
        'nilai_capaian_skp',
        'nilai_perilaku',
        'nilai_akhir',
        'kategori',
    ];

    /**
     * Relasi ke model Pegawai (pegawai yang dinilai).
     */
    public function pegawaiDinilai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_dinilai_id');
    }

    /**
     * Relasi ke model Pegawai (pegawai penilai).
     */
    public function pegawaiPenilai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_penilai_id');
    }

    /**
     * Relasi ke model Pegawai (atasan pegawai penilai).
     */
    public function atasanPegawaiPenilai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'atasan_pegawai_penilai_id');
    }

    /**
     * Relasi ke model SkpKegiatan.
     * Sebuah SKP Header memiliki banyak Kegiatan.
     */
    public function kegiatan(): HasMany
    {
        return $this->hasMany(SkpKegiatan::class, 'skp_header_id');
    }

    /**
     * Relasi ke model SkpCatatanPenilaian.
     * Sebuah SKP Header memiliki satu catatan penilaian.
     */
    public function catatanPenilaian(): HasMany
    {
        return $this->hasMany(SkpCatatanPenilaian::class, 'skp_header_id');
    }
}