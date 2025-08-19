<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisis';

    protected $fillable = [
        'surat_dari',
        'no_surat',
        'tgl_surat',
        'tgl_diterima',
        'no_agenda',
        'sifat',
        'hal',
        'diteruskan_kepada',
        'harap',
        'catatan',
        'penandatangan_id',
    ];

    protected $casts = [
        'diteruskan_kepada' => 'array',
        'harap' => 'array',
    ];

    public function penandatangan()
    {
        return $this->belongsTo(Pegawai::class, 'penandatangan_id');
    }
}
