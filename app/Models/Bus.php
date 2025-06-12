<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number',
        'registration_id',
        'driver_id',
        'route_id',
        'image_01',
        'is_active',
        'is_filed',
        'latitude',
        'longitude',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function locationTracking()
    {
        return $this->hasMany(LocationTracking::class);
    }

    public function aiPredictions()
    {
        return $this->hasMany(AiPrediction::class);
    }
}
