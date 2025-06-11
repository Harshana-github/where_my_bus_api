<?php

namespace App\Http\DataLayer;

use App\Models\Driver;

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
}
