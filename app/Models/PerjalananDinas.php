<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerjalananDinas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lembar_ke',
        'kode_no',  
        'nomor',
        'pegawai_id',
        'tingkat_biaya',
        'maksud_perjalanan',
        'alat_angkut',
        'tempat_berangkat',
        'tempat_tujuan',
        'lama_perjalanan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'pengikut',
        'skpd_pembebanan',
        'kode_rekening_pembebanan',
        'keterangan_lain',
        'kuasa_pengguna_anggaran_id',
        'tanggal_dikeluarkan',
        'riwayat_perjalanan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikeluarkan' => 'date',
        'pengikut' => 'array',
        'riwayat_perjalanan' => 'array',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function kuasaPenggunaAnggaran(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kuasa_pengguna_anggaran_id');
    }
}
