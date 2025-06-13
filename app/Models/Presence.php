<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    protected $fillable = [
        'pegawai_id',
        'check_in',
        'check_out',
        // 'latitude',
        // 'longitude',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Periksa apakah pegawai sudah Check In hari ini
    public static function hasCheckedInToday($pegawai_id)
    {
        return self::where('pegawai_id', $pegawai_id)
            ->whereDate('check_in', Carbon::today())
            ->exists();
    }

    // Periksa apakah pegawai sudah Check Out hari ini
    public static function hasCheckedOutToday($pegawai_id)
    {
        return self::where('pegawai_id', $pegawai_id)
            ->whereDate('check_out', Carbon::today())
            ->exists();
    }

    public function getFormattedCheckInAttribute()
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('d-m-Y H:i:s') : null;
    }

    public function getFormattedCheckOutAttribute()
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('d-m-Y H:i:s') : null;
    }
}
