<?php

namespace App\Http\DataLayer;

use App\Models\Bus;

class BusDataLayer
{
    // public function getAll()
    // {
    //     return Bus::with(['driver', 'route'])->orderBy('id')->get();
    // }

    public function getAll()
    {
        return Bus::with([
            'driver.user:id,name,latitude,longitude', // <-- add this
            'route:id,route_name',
        ])
            ->orderBy('id')
            ->get([
                'id',
                'bus_number',
                'driver_id',
                'route_id',
                'latitude',
                'longitude',
                'created_at',
                'updated_at'
            ]);
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
