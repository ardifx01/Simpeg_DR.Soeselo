<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notula extends Model
{
    use HasFactory;

    protected $fillable = [
        'sidang_rapat', 'tanggal', 'waktu',
        'surat_undangan', 'acara', 'ketua_id','sekretaris_id',
        'pencatat_id', 'peserta', 'kegiatan_rapat',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime:H:i',
        'peserta' => 'array',
    ];

    // Relasi ke pegawai
    public function ketua()
    {
        return $this->belongsTo(Pegawai::class, 'ketua_id');
    }

    public function sekretaris()
    {
        return $this->belongsTo(Pegawai::class, 'sekretaris_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(Pegawai::class, 'pencatat_id');
    }

    public function pesertaPegawai()
    {
        return Pegawai::whereIn('id', $this->peserta ?? [])->get();
    }

}
