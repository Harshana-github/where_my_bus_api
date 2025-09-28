<?php

namespace App\Http\DataLayer;

use App\Models\Bus;

class BusDataLayer
{
    public function getAll()
    {
        // return Bus::with(['driver', 'route'])->orderBy('id')->get();

        return Bus::with([
            // bring the driver's user so we have name & coords
            'driver.user:id,name,latitude,longitude',
            // you only need the route name for the UI
            'route:id,route_name'
        ])
            // return only the columns you need from buses table (optional but tidy)
            ->get(['id', 'bus_number', 'driver_id', 'route_id', 'latitude', 'longitude', 'created_at', 'updated_at']);
    }

    public function insert(array $data)
    {
        return Bus::create($data);
    }

    public function update($id, array $data)
    {
        $bus = Bus::findOrFail($id);
        $bus->update($data);
        return $bus;
    }

    public function delete($id)
    {
        $bus = Bus::findOrFail($id);
        return $bus->delete();
    }

    public function find($id)
    {
        return Bus::with(['driver', 'route'])->findOrFail($id);
    }

    public function getAllWithRoutes()
    {
        return Bus::with('route')->get();
    }

    public function getByDriver($driverId)
    {
        return Bus::where('driver_id', $driverId)->with('route')->get();
    }
}
