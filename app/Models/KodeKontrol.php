<?php

namespace App\Models;

use App\Http\Controllers\Api\SettingKodeKontrolController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class KodeKontrol extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'kode_kontrol';
    protected $fillable = [
        'merk_id',
        'kode',
        'alias'
    ];

    public function merk()
    {
        return $this->belongsTo(Merk::class);
    }

    public function setting_kode_kontrol()
    {
        return $this->hasMany(SettingKodeKontrolController::class);
    }
}
