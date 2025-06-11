<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\LocationTrackingDataLayer;
use App\Http\Requests\StoreLocationTrackingRequest;
use App\Http\Requests\UpdateLocationTrackingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationTrackingController extends Controller
{
    protected $locationDL;

    public function __construct(LocationTrackingDataLayer $locationDL)
    {
        $this->locationDL = $locationDL;
    }

    public function index()
    {
        try {
            return response()->json($this->locationDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch location tracking data: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch records'], 500);
        }
    }

    public function store(StoreLocationTrackingRequest $request)
    {
        try {
            $record = $this->locationDL->insert($request->validated());
            return response()->json($record, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create location tracking record: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create record'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->locationDL->find($id));
        } catch (\Exception $e) {
            Log::error("Failed to get location tracking record: " . $e->getMessage());
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    public function update(UpdateLocationTrackingRequest $request, $id)
    {
        try {
            $record = $this->locationDL->update($id, $request->validated());
            return response()->json($record);
        } catch (\Exception $e) {
            Log::error("Failed to update location tracking record: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update record'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->locationDL->delete($id);
            return response()->json(['message' => 'Record deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete location tracking record: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete record'], 500);
        }
    }
}
