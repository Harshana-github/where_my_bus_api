<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude', 'is_active'];


    public function routes()
    {
        return $this->belongsToMany(Route::class, 'route_town');
    }

    public function routesStartingHere()
    {
        return $this->hasMany(Route::class, 'start_town_id');
    }

    public function routesEndingHere()
    {
        return $this->hasMany(Route::class, 'end_town_id');
    }
}
