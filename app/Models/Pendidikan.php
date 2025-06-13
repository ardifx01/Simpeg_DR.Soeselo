<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendidikan extends Model
{
    /** @use HasFactory<\Database\Factories\PendidikanFactory> */
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'tingkat',
        'jurusan',
        'nama',
        'tahun_lulus',
        'no_ijazah',
        'tanggal_ijazah'
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
