<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembinaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pegawai_id', 'nama', 'pekerjaan', 'agama', 'alamat', 'hubungan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
