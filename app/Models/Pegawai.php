<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $guarded = [];
    
    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function jabatan(): HasOne
    {
        return $this->hasOne(Jabatan::class, 'pegawai_id', 'id');
    }

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
    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class)->orderBy('tingkat', 'desc');
    }
    
    public function ijin_belajars(): HasMany
    {
        return $this->hasMany(Ijinbelajar::class, 'pegawai_id');
    }
    
    public function arsips(): HasMany
    {
        return $this->hasMany(Arsip::class, 'pegawai_id');
    }
    
    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
}
