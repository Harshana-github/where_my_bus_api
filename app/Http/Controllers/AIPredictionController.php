<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\AIPredictionDataLayer;
use App\Http\Requests\StoreAIPredictionRequest;
use App\Http\Requests\UpdateAIPredictionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AIPredictionController extends Controller
{
    protected $aiDL;

    public function __construct(AIPredictionDataLayer $aiDL)
    {
        $this->aiDL = $aiDL;
    }

    public function index()
    {
        try {
            return response()->json($this->aiDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch predictions: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch records'], 500);
        }
    }

    public function store(StoreAIPredictionRequest $request)
    {
        try {
            $record = $this->aiDL->insert($request->validated());
            return response()->json($record, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create AI prediction: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create record'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->aiDL->find($id));
        } catch (\Exception $e) {
            Log::error("Failed to get AI prediction: " . $e->getMessage());
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    public function update(UpdateAIPredictionRequest $request, $id)
    {
        try {
            $record = $this->aiDL->update($id, $request->validated());
            return response()->json($record);
        } catch (\Exception $e) {
            Log::error("Failed to update AI prediction: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update record'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->aiDL->delete($id);
            return response()->json(['message' => 'Record deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete AI prediction: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete record'], 500);
        }
    }
}
