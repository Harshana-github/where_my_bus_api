<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_number',
        'phone',
        'profile_image',
        'is_active',
        'is_filed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
