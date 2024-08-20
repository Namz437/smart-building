<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class History extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'history';
    protected $fillable = [
        'users_id',
        'device_id',
        'status',
        'waktu',
        'deskripsi',
        'harga',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function Device()
    {
        return $this->belongsTo(Device::class);
    }
}
