<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Gedung extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'gedung';
    protected $fillable = [
        'nama_gedung',
        'deskripsi',
        'perusahaan_id'
    ];

    public function lantai()
    {
        return $this->hasMany(Lantai::class);
    }
        public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
