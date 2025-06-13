<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anak extends Model
{
    /** @use HasFactory<\Database\Factories\AnakFactory> */
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'status_keluarga',
        'status_tunjangan',
        'jenis_kelamin'
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
