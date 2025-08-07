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
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'pos',
        'telepon'
    ];

    public function getNamaLengkapAttribute()
    {
        $nama = trim("{$this->gelar_depan} {$this->nama}");
        if ($this->gelar_belakang) {
            $nama .= ", {$this->gelar_belakang}";
        }
        return $nama;
    }

    public function getAlamatLengkapAttribute()
    {
        $alamat = trim("{$this->desa}, RT {$this->rt}/RW {$this->rw}, Desa {$this->desa}, Kecamatan {$this->kecamatan}, Kabupaten {$this->kabupaten}, Provinsi {$this->provinsi}");
        if ($this->pos) {
            $alamat .= ", Kode Pos: {$this->pos}";
        }
        return $alamat;
    }

    public function getPangkatGolonganAttribute()
    {
        $pangkat = optional($this->jabatan)->pangkat;
        $golongan = optional($this->jabatan)->golongan_ruang;

        if ($pangkat && $golongan) {
            return "$pangkat ($golongan)";
        }

        if ($pangkat) {
            return $pangkat;
        }

        if ($golongan) {
            return $golongan;
        }

        return '-';
    }
    
    // Accessor agar tetap bisa tampil d-m-Y jika ingin
    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
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
