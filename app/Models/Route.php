<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'start_town_id',
        'end_town_id',
        'is_active',
        'is_filed',
        'main_town_ids',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'is_filed'      => 'boolean',
        'main_town_ids' => 'array', 
    ];

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function locationTrackings()
    {
        return $this->hasMany(LocationTracking::class);
    }

    // Many-to-many remains if you still use the route_town pivot for via-towns
    public function towns()
    {
        return $this->belongsToMany(Town::class, 'route_town');
    }

    // NEW: direct start/end relations
    public function startTown()
    {
        return $this->belongsTo(Town::class, 'start_town_id');
    }

    public function endTown()
    {
        return $this->belongsTo(Town::class, 'end_town_id');
    }
}
