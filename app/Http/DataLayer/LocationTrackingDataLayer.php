<?php

namespace App\Http\DataLayer;

use App\Models\LocationTracking;

class LocationTrackingDataLayer
{
    public function getAll()
    {
        return LocationTracking::with('bus')->get();
    }

    public function find($id)
    {
        return LocationTracking::with('bus')->findOrFail($id);
    }

    public function insert($data)
    {
        return LocationTracking::create($data);
    }

    public function update($id, $data)
    {
        $location = LocationTracking::findOrFail($id);
        $location->update($data);
        return $location;
    }

    public function delete($id)
    {
        LocationTracking::destroy($id);
    }
}
