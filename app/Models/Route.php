<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['route_name', 'start_location', 'end_location'];

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function locationTrackings()
    {
        return $this->hasMany(LocationTracking::class);
    }
}
