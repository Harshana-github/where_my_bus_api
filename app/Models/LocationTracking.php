<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationTracking extends Model
{
    use HasFactory;

    protected $table = 'location_tracking';

    protected $fillable = [
        'bus_id',
        'user_id',
        'latitude',
        'longitude',
        'timestamp'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
