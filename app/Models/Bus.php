<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = ['bus_number', 'registration_id', 'driver_id', 'route_id'];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function locationTrackings()
    {
        return $this->hasMany(LocationTracking::class);
    }

    public function aiPredictions()
    {
        return $this->hasMany(AIPrediction::class);
    }
}
