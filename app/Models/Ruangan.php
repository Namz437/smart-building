<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Ruangan extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'ruangan';
    protected $fillable = [
        'perusahaan_id',
        'lantai_id',
        'nama_ruangan',
        'deskripsi',
        'ukuran',
        'perusahaan_id',
    ];
    public function lantai()
    {
        return $this->belongsTo(Lantai::class);
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function aksesroles()
    {
        return $this->hasMany(AksesRoles::class);
    }
}
