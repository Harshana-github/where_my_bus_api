<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;


class TownController extends Controller
{
    // GET /towns
    public function index()
    {
        return Town::where('is_active', true)
            ->select('id', 'name')
            ->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Town::create($validatedData);
    }

    public function show($id)
    {
        return Town::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $town = Town::findOrFail($id);
        $town->update($request);
        return $town;
    }

    public function destroy($id)
    {
        $town = Town::findOrFail($id);
        $town->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
