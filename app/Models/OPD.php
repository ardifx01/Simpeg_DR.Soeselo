<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OPD extends Model
{
    use HasFactory;

    protected $table = 'opds';
    protected $fillable = ['nama_opd', 'alamat', 'pegawai_id'];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
