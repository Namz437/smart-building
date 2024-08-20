<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class CategoryDevice extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'category_device';
    protected $fillable = [
        'nama_category',
        'deskripsi',
    ];

    public function jenis_device()
    {
        return $this->hasOne(JenisDevice::class);
    }
}
