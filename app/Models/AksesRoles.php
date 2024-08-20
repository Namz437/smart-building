<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class AksesRoles extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'akses_roles';
    protected $fillable = [
        'roles_id',
        'ruangan_id'
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
