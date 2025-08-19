<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkpTambahan extends Model
{
    protected $table = 'skp_tambahans';
    
    protected $fillable = [
        'skp_header_id',
        'nama_tambahan',
        'nilai_tambahan',
    ];

    // Relasi balik ke SKP Header
    public function skpHeader()
    {
        return $this->belongsTo(SkpHeader::class);
    }
}
