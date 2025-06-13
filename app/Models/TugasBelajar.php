<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasBelajar extends Model
{
    protected $fillable = [
        'pegawai_id', 'program', 'lembaga', 'fakultas', 'program_studi'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
