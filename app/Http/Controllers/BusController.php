<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\BusDataLayer;
use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusController extends Controller
{
    protected $busDL;

    public function __construct(BusDataLayer $busDL)
    {
        $this->busDL = $busDL;
    }

    public function index()
    {
        try {
            return response()->json($this->busDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch buses: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch buses'], 500);
        }
    }

    public function store(StoreBusRequest $request)
    {
        try {
            $bus = $this->busDL->insert($request->validated());
            return response()->json($bus, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create bus: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create bus'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->busDL->find($id));
        } catch (\Exception $e) {
            Log::error("Failed to get bus: " . $e->getMessage());
            return response()->json(['error' => 'Bus not found'], 404);
        }
    }

    public function update(UpdateBusRequest $request, $id)
    {
        try {
            $bus = $this->busDL->update($id, $request->validated());
            return response()->json($bus);
        } catch (\Exception $e) {
            Log::error("Failed to update bus: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update bus'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $this->busDL->delete($id);
            return response()->json(['message' => 'Bus deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete bus: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete bus'], 500);
        }
    }
}
