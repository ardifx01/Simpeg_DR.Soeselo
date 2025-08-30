<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TugasBelajar extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'program',
        'lembaga',
        'fakultas',
        'program_studi',
        'atasan_id',
        'atasan_nama',
        'atasan_nip',
        'atasan_pangkat',
        'atasan_golongan_ruang',
        'atasan_jabatan',
    ];

    /**
     * Get the pegawai that owns the TugasBelajar.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    /**
     * Get the atasan that owns the TugasBelajar.
     */
    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }
}
