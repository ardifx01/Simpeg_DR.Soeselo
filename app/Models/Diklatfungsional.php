<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diklatfungsional extends Model
{
    /** @use HasFactory<\Database\Factories\DiklatfungsionalFactory> */
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'nama', 
        'penyelenggara', 
        'jumlah_jam', 
        'tanggal_selesai'
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}