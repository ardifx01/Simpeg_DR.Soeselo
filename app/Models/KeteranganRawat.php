<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeteranganRawat extends Model
{
    use HasFactory, SoftDeletes;

    // Nama tabel di database
    protected $table = 'keterangan_rawats';
    
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
