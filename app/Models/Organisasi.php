<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organisasi extends Model
{
    /** @use HasFactory<\Database\Factories\OrganisasiFactory> */
    use HasFactory;

    protected $table = 'organisasis';
    protected $guarded = [];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
