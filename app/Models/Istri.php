<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Istri extends Model
{
    /** @use HasFactory<\Database\Factories\IstriFactory> */
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'nama', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'profesi', 
        'tanggal_nikah',
        'status_hubungan'
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
