<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Edaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'tahun',
        'tentang',
        'isi_edaran',
        'tempat_ditetapkan',
        'tanggal_ditetapkan',
        'penandatangan_id',
        'tujuan',
    ];

    protected $casts = [
        'tujuan' => 'array',
        'tanggal_ditetapkan' => 'date',
    ];

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
