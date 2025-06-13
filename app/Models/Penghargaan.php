<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penghargaan extends Model
{
    /** @use HasFactory<\Database\Factories\PenghargaanFactory> */
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'nama',
        'pemberi',
        'tahun'
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
