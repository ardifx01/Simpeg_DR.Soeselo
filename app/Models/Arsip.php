<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    /** @use HasFactory<\Database\Factories\ArsipFactory> */
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'jenis',
        'file'
    ];
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
