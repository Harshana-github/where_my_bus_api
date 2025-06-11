<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\RouteDataLayer;
use App\Http\Requests\StoreRoutesRequest;
use App\Http\Requests\UpdateRoutesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    protected $routeDL;

    public function __construct(RouteDataLayer $routeDL)
    {
        $this->routeDL = $routeDL;
    }

    public function index()
    {
        try {
            return response()->json($this->routeDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch routes: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch routes'], 500);
        }
    }

    public function store(StoreRoutesRequest $request)
    {
        try {
            $route = $this->routeDL->insert($request->validated());
            return response()->json($route, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create route: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create route'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->routeDL->find($id));
        } catch (\Exception $e) {
            Log::error("Failed to get route: " . $e->getMessage());
            return response()->json(['error' => 'Route not found'], 404);
        }
    }

    public function update(UpdateRoutesRequest $request, $id)
    {
        try {
            $route = $this->routeDL->update($id, $request->validated());
            return response()->json($route);
        } catch (\Exception $e) {
            Log::error("Failed to update route: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update route'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->routeDL->delete($id);
            return response()->json(['message' => 'Route deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete route: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete route'], 500);
        }
    }
}
