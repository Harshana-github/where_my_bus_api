<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\DriverDataLayer;
use App\Http\Requests\StoreDriverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    protected $driverDL;

    public function __construct(DriverDataLayer $driverDL)
    {
        $this->driverDL = $driverDL;
    }
    public function index()
    {
        try {
            return response()->json($this->driverDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch drivers: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch drivers'], 500);
        }
    }

    public function store(StoreDriverRequest $request)
    {
        try {
            $driver = $this->driverDL->insert($request->validated());
            return response()->json($driver, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create driver: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create driver'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->driverDL->find($id));
        } catch (\Exception $e) {
            Log::error("Failed to get driver: " . $e->getMessage());
            return response()->json(['error' => 'Driver not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $driver = $this->driverDL->update($id, $request->validated());
            return response()->json($driver);
        } catch (\Exception $e) {
            Log::error("Failed to update driver: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update driver'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->driverDL->delete($id);
            return response()->json(['message' => 'Driver deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete driver: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete driver'], 500);
        }
    }
}
