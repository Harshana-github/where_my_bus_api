<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $fillable = ['name,is_active'];

    public function routes()
    {
        return $this->belongsToMany(Route::class, 'route_town');
    }
}
