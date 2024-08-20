<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Favorite extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'favorite';
    protected $fillable = [
        'users_id',
        'ruangan_id',
    ];

    public function users()
    {
        return $this->belongsTo(Lantai::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
