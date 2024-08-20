<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SettingRoles extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'setting_roles';
    protected $fillable = ['users_id', 'roles_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

    public function device()
    {
        return $this->hasMany(Device::class);
    }
}
