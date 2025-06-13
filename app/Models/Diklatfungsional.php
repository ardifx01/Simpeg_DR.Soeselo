<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diklatfungsional extends Model
{
    /** @use HasFactory<\Database\Factories\DiklatfungsionalFactory> */
    use HasFactory;
    
    protected $table = 'diklatfungsionals';
    protected $guarded = [];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}