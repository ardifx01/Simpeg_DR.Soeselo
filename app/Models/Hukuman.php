<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hukuman extends Model
{
    protected $fillable = [
        'pegawai_id', 'bentuk_pelanggaran', 'waktu', 'tempat', 'faktor_meringankan',
        'faktor_memberatkan', 'pwkt', 'no', 'tahun', 'pasal',
        'tentang','jenis_hukuman','keterangan_hukuman','peraturan',
        'hari', 'tanggal', 'jam', 'dampak'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
