<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perusahaan extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'perusahaan';
    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'image',
        'kwh',
        'harga_kwh'
    ];

    public function gedung()
    {
        return $this->hasMany(Gedung::class);
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }

}
