<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    /** @use HasFactory<\Database\Factories\JabatanFactory> */
    use HasFactory;

    protected $table = 'jabatans';
    protected $fillable = [
        'pegawai_id', 'skpd', 'unit_kerja', 'pangkat', 'nama_jabatan', 'formasi_jabatan', 'formasi_jabatan_tingkat', 'formasi_jabatan_keterangan',
        'jenis_kepegawaian', 'jenis_jabatan', 'status', 'tmt', 'eselon',
        'sk_pengangkatan_blud', 'tgl_sk_pengangkatan_blud', 'mou_awal_blud', 'tgl_mou_awal_blud', 'tmt_awal_mou_blud', 'tmt_akhir_mou_blud',
        'mou_akhir_blud', 'tgl_akhir_blud', 'tmt_mou_akhir', 'tmt_akhir_mou',
        'no_mou_mitra', 'tgl_mou_mitra', 'tmt_mou_mitra', 'tmt_akhir_mou_mitra'
    ];
    
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
