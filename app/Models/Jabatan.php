<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    /** @use HasFactory<\Database\Factories\JabatanFactory> */
    use HasFactory;

    protected $table = 'jabatans';
    protected $fillable = [
        'pegawai_id', 'skpd', 'unit_kerja', 'nama', 'jenis_kepegawaian', 
        'jenis_jabatan', 'status', 'tmt', 'eselon'
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
