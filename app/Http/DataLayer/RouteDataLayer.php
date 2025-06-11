<?php

namespace App\Http\DataLayer;

use App\Models\Route;

class RouteDataLayer
{
    public function getAll()
    {
        return Route::with('towns')->orderBy('id')->get();
    }

    public function find($id)
    {
        return Route::with('towns')->findOrFail($id);
    }

    public function insert(array $data)
    {
        return Route::create($data);
    }

    public function update($id, array $data)
    {
        $route = Route::findOrFail($id);
        $route->update($data);
        return $route;
    }

    public function delete($id)
    {
        return Route::findOrFail($id)->delete();
    }

    public function getTownsByRoute($routeId)
    {
        return Route::with('towns')->findOrFail($routeId)->towns;
    }

    public function syncTowns($routeId, array $townIds)
    {
        $route = Route::findOrFail($routeId);
        $route->towns()->sync($townIds);
        return $route->load('towns');
    }
}
