<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SettingKodeKontrol extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'setting_kode_kontrol';
    protected $fillable = [
        'device_id',
        'kode_kontrol_id',
    ];

    public function kode_kontrol()
    {
        return $this->belongsTo(KodeKontrol::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
