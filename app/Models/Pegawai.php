<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory;

    protected $table = 'pegawais';
    protected $guarded = [];
    
    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    protected $fillable = [
        'image',
        'nip',
        'nip_lama',
        'no_karpeg',
        'no_kpe',
        'no_ktp',
        'no_npwp',
        'nama',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_nikah',
        'alamat',
        'telepon',
        'tingkat_pendidikan',
        'nama_pendidikan',
        'nama_sekolah',
        'tahun_lulus',
        'pangkat',
        'golongan_ruang',
        'tmt_golongan_ruang',
        'golongan_ruang_cpns',
        'tmt_golongan_ruang_cpns',
        'tmt_pns',
        'jenis_kepegawaian',
        'status_hukum',
        'skpd',
        'jenis_jabatan',
        'jabatan_fungsional',
        'tmt_jabatan',
        'diklat_pimpinan',
        'tahun_diklat_pimpinan'
    ];

    public function istris(): HasMany
    {
        return $this->hasMany(Istri::class, 'pegawai_id');
    }
    
    public function anaks(): HasMany
    {
        return $this->hasMany(Anak::class, 'pegawai_id');
    }

    public function diklat_fungsionals(): HasMany
    {
        return $this->hasMany(Diklatfungsional::class, 'pegawai_id');

    }public function diklat_jabatans(): HasMany
    {
        return $this->hasMany(Diklatjabatan::class, 'pegawai_id');
    }

    public function diklat_tekniks(): HasMany
    {
        return $this->hasMany(Diklatteknik::class, 'pegawai_id');
    }

    public function penghargaans(): HasMany
    {
        return $this->hasMany(Penghargaan::class, 'pegawai_id');
    }
    
    public function organisasis(): HasMany
    {
        return $this->hasMany(Organisasi::class, 'pegawai_id');
    }
    public function pendidikans(): HasMany
    {
        return $this->hasMany(Pendidikan::class, 'pegawai_id');
    }
    
    public function ijin_belajars(): HasMany
    {
        return $this->hasMany(Ijinbelajar::class, 'pegawai_id');
    }
    
    public function arsips(): HasMany
    {
        return $this->hasMany(Arsip::class, 'pegawai_id');
    }
    
    public function jabatans(): HasOne
    {
        return $this->hasOne(Jabatan::class, 'pegawai_id');
    }
    public function opd(): HasOne
    {
        return $this->hasOne(OPD::class, 'pegawai_id');
    }

    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
}
