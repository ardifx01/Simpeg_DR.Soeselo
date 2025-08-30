<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telaahan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'yth_id', 'dari_id', 'nomor', 'tanggal', 'lampiran', 'hal',
        'persoalan', 'praanggapan', 'fakta', 'analisis', 'kesimpulan', 'saran',
        'penandatangan_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function yth()
    {
        return $this->belongsTo(Pegawai::class, 'yth_id');
    }

    public function dari()
    {
        return $this->belongsTo(Pegawai::class, 'dari_id');
    }

    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }

}
