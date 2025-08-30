<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkpTambahan extends Model
{
    use HasFactory, SoftDeletes;
    
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
