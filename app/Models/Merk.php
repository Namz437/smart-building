<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Merk extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'merk';
    protected $fillable = ['nama_merk', 'deskripsi'];

    public function kodekontrol()
    {
        return $this->hasMany(KodeKontrol::class);
    }
}
