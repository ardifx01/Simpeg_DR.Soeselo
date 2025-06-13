<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diklatjabatan extends Model
{
    /** @use HasFactory<\Database\Factories\DiklatjabatanFactory> */
    use HasFactory;
    
    protected $table = 'diklatjabatans';
    protected $guarded = [];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
