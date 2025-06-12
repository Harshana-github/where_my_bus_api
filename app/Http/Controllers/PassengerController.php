<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = $request->user(); // Get the logged-in user

        if ($user->user_type !== 'passenger') {
            return response()->json(['message' => 'Only passengers can update location.'], 403);
        }

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json(['message' => 'Passenger location updated successfully.']);
    }
}
