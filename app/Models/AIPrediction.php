<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIPrediction extends Model
{
    use HasFactory;

    protected $fillable = ['bus_id', 'predicted_arrival_time', 'distance', 'speed', 'traffic_condition', 'prediction_timestamp'];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
