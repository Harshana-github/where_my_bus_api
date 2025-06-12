<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = $request->user();

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json(['message' => 'Passenger location updated successfully.']);
    }

    public function locations()
    {
        return response()->json(
            User::where('user_type', 'driver')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get(['id', 'name', 'latitude', 'longitude'])
        );
    }
}
