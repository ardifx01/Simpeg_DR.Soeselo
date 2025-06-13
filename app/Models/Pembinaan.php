<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembinaan extends Model
{
    protected $fillable = [
        'pegawai_id', 'nama', 'pekerjaan', 'agama', 'alamat', 'hubungan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
