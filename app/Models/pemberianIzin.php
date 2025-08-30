<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class pemberianIzin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id',
        'pemberi_izin_id',
        'nomor_surat',
        'tentang',
        'dasar_hukum',
        'tujuan_izin',
        'ditetapkan_di',
        'tanggal_penetapan',
        'tembusan',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pemberiIzin(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pemberi_izin_id');
    }
}
