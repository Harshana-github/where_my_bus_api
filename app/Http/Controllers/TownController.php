<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TownController extends Controller
{
    /**
     * GET /towns
     * Optional: /towns?active=1 to return only active towns
     */
    public function index(Request $request)
    {
        $onlyActive = (string) $request->query('active', '') === '1';

        $q = Town::query()
            ->when($onlyActive, fn($qq) => $qq->where('is_active', true))
            ->orderBy('id');

        // Select all useful fields (adjust as needed)
        $towns = $q->get(['id', 'name', 'is_active', 'latitude', 'longitude']);

        return response()->json($towns);
    }

    /**
     * POST /towns
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255', 'unique:towns,name'],
            'is_active'  => ['sometimes', 'boolean'],
            'latitude'   => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
        ]);

        // Default is_active to true if omitted
        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = true;
        }

        $town = Town::create($validated);

        return response()->json($town, 201);
    }

    /**
     * GET /towns/{id}
     */
    public function show($id)
    {
        $town = Town::findOrFail($id);
        return response()->json($town);
    }

    /**
     * PUT /towns/{id}
     */
    public function update(Request $request, $id)
    {
        $town = Town::findOrFail($id);

        $validated = $request->validate([
            'name'       => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('towns', 'name')->ignore($town->id),
            ],
            'is_active'  => ['sometimes', 'boolean'],
            'latitude'   => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
        ]);

        // ✅ Pass attributes array (not the Request object)
        $town->update($validated);

        return response()->json($town);
    }

    /**
     * DELETE /towns/{id}
     */
    public function destroy($id)
    {
        $town = Town::findOrFail($id);
        $town->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
