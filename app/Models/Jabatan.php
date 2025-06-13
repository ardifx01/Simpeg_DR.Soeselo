<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    /** @use HasFactory<\Database\Factories\JabatanFactory> */
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'nama',
        'skpd',
        'tmt',
        'eselon'
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
