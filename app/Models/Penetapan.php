<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penetapan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penetapans';

    protected $fillable = [
        'pegawai_id',
        'nomor_surat',
        'tahun_surat',
        'tanggal_penetapan',
        'tentang',
        'menimbang',
        'mengingat',
        'memutuskan',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
    ];

    // Relasi: pejabat yang menetapkan (Pegawai)
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
