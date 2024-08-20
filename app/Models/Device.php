<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'device';
    protected $fillable = [
        'nama_device',
        'url',
        'jenis_device_id',
        'ruangan_id',
        'merk_id',
        'suhu',
        'status',
        'min_suhu',
        'max_suhu',
        'watt',
        'mac_address',
    ];

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function jenis_device()
    {
        return $this->belongsTo(JenisDevice::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function merk()
    {
        return $this->belongsTo(Merk::class);
    }

    public function setting_kode_kontrol()
    {
        return $this->hasMany(SettingKodeKontrol::class);
    }
}
