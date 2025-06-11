<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\BusDataLayer;
use App\Http\DataLayer\RouteDataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomRouteController extends Controller
{
    protected $busDL;
    protected $routeDL;

    public function __construct(BusDataLayer $busDL, RouteDataLayer $routeDL)
    {
        $this->busDL = $busDL;
        $this->routeDL = $routeDL;
    }

    // GET /api/bus-routes
    public function busRoutes()
    {
        try {
            return response()->json($this->busDL->getAllWithRoutes());
        } catch (\Exception $e) {
            Log::error("Failed to fetch bus-routes: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch bus-routes'], 500);
        }
    }

    // GET /api/driver/{id}/buses
    public function driverBuses($id)
    {
        try {
            return response()->json($this->busDL->getByDriver($id));
        } catch (\Exception $e) {
            Log::error("Failed to fetch driver's buses: " . $e->getMessage());
            return response()->json(['error' => "Failed to fetch driver's buses"], 500);
        }
    }

    // GET /api/routes/{id}/towns
    public function routeTowns($id)
    {
        try {
            return response()->json($this->routeDL->getTownsByRoute($id));
        } catch (\Exception $e) {
            Log::error("Failed to fetch towns for route: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch towns'], 500);
        }
    }

    // POST /api/routes/{id}/towns
    public function syncRouteTowns(Request $request, $id)
    {
        try {
            $request->validate([
                'town_ids' => 'required|array',
                'town_ids.*' => 'exists:towns,id',
            ]);

            $route = $this->routeDL->syncTowns($id, $request->town_ids);
            return response()->json(['message' => 'Towns synced successfully', 'route' => $route]);
        } catch (\Exception $e) {
            Log::error("Failed to sync towns for route: " . $e->getMessage());
            return response()->json(['error' => 'Failed to sync towns'], 500);
        }
    }
}
