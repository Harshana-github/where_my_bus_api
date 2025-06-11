<?php

namespace App\Http\DataLayer;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class DriverDataLayer
{
    public function getAll()
    {
        return Driver::with('user')->orderBy('id')->get();
    }

    public function find($id)
    {
        return Driver::with('user')->findOrFail($id);
    }

    public function insert(array $data)
    {
        return Driver::create($data);
    }

    public function update($id, array $data)
    {
        $driver = Driver::findOrFail($id);
        $driver->update($data);
        return $driver;
    }

    public function delete($id)
    {
        return Driver::findOrFail($id)->delete();
    }

    public function insertProfile($data)
    {
        return DB::transaction(function () use ($data) {
            $driverData = $data->input('driver');
            $routeData = $data->input('route');
            $busData = $data->input('bus');

            // Step 1: Create Driver
            $driver = Driver::create($driverData);

            // Step 2: Create Route
            $route = Route::create($routeData);

            // Step 3: Attach references to Bus
            $busData['driver_id'] = $driver->id;
            $busData['route_id'] = $route->id;

            // Step 4: Create Bus
            $bus = Bus::create($busData);

            return [
                'driver' => $driver,
                'route' => $route,
                'bus' => $bus,
            ];
        });
    }
}
