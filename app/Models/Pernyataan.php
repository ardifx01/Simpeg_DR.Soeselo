<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pernyataan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tempat_surat',

        'pejabat_id',
        'pegawai_id',

        'peraturan_tugas',
        'nomor_peraturan',
        'tahun_peraturan',
        'tentang_peraturan',
        'tanggal_mulai_tugas',
        'jabatan_tugas',
        'lokasi_tugas',

        'tembusan',
    ];

    protected $casts = [
        'tanggal_surat'       => 'date',
        'tanggal_mulai_tugas' => 'date',
        'tembusan'            => 'array',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pejabat()
    {
        return $this->belongsTo(Pegawai::class, 'pejabat_id');
    }
}
