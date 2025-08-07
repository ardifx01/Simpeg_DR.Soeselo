<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterangan extends Model
{
    protected $fillable = [
        'pegawai_id', 'jenis_keterangan', 'nama', 'nik', 'tempat_lahir',
        'tanggal_lahir', 'agama', 'pekerjaan', 'alamat', 'hubungan',
        'status_rawat'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
