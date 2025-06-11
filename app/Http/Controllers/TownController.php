<?php

namespace App\Http\Controllers;

use App\Http\DataLayer\TownDataLayer;
use App\Http\Requests\StoreTownRequest;
use App\Http\Requests\UpdateTownRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TownController extends Controller
{
    protected $townDL;

    public function __construct(TownDataLayer $townDL)
    {
        $this->townDL = $townDL;
    }
    public function index()
    {
        try {
            return response()->json($this->townDL->getAll());
        } catch (\Exception $e) {
            Log::error("Failed to fetch towns: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch towns'], 500);
        }
    }

    public function store(StoreTownRequest $request)
    {
        try {
            $town = $this->townDL->insert($request->validated());
            return response()->json($town, 201);
        } catch (\Exception $e) {
            Log::error("Failed to create town: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create town'], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->townDL->find($id));
        } catch (\Exception $e) {
            Log::error("Town not found: " . $e->getMessage());
            return response()->json(['error' => 'Town not found'], 404);
        }
    }

    public function update(UpdateTownRequest $request, $id)
    {
        try {
            $town = $this->townDL->update($id, $request->validated());
            return response()->json($town);
        } catch (\Exception $e) {
            Log::error("Failed to update town: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update town'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->townDL->delete($id);
            return response()->json(['message' => 'Town deleted']);
        } catch (\Exception $e) {
            Log::error("Failed to delete town: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete town'], 500);
        }
    }
}
