<?php

namespace App\Http\Controllers;

use App\Events\UserLocationUpdated;
use App\Models\LocationTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function updateUserLocation(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'bus_id'    => 'nullable|integer',
        ]);
        /** @var \App\Models\User $user */
        $user = auth('api')->user();
        if (!$user) return response()->json(['message' => 'Unauthenticated'], 401);

        // Persist on user row
        $user->update([
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Optional: record tracking (if you want a history)
        LocationTracking::create([
            'bus_id'   => $request->input('bus_id'),
            'user_id'  => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => now(),
        ]);

        // Broadcast to appropriate channel
        $role = $user->user_type; // 'driver' or 'passenger'
        broadcast(new UserLocationUpdated(
            $user->id,
            $role,
            $request->latitude,
            $request->longitude,
            $request->input('bus_id')
        ))->toOthers();

        return response()->json(['message' => 'Location updated']);
    }

    // Optional: server-side ETA using Google Distance Matrix (protects your key)
    public function eta(Request $request)
    {
        $request->validate([
            'origin_lat' => 'required|numeric',
            'origin_lng' => 'required|numeric',
            'dest_lat'   => 'required|numeric',
            'dest_lng'   => 'required|numeric',
        ]);

        $key = config('services.google.maps_key') ?? env('GOOGLE_MAPS_SERVER_KEY');
        if (!$key) return response()->json(['error' => 'Google key missing'], 500);

        $origin = "{$request->origin_lat},{$request->origin_lng}";
        $dest = "{$request->dest_lat},{$request->dest_lng}";

        $res = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins'      => $origin,
            'destinations' => $dest,
            'key'          => $key,
            'mode'         => 'driving',
            'departure_time' => 'now',
        ]);

        if (!$res->ok()) return response()->json(['error' => 'Google API error'], 500);

        $json = $res->json();
        $element = $json['rows'][0]['elements'][0] ?? null;
        if (!$element || ($element['status'] ?? '') !== 'OK') {
            return response()->json(['error' => 'No ETA'], 422);
        }

        return response()->json([
            'distance_text' => $element['distance']['text'] ?? null,
            'distance_value' => $element['distance']['value'] ?? null,
            'duration_text' => $element['duration_in_traffic']['text'] ?? ($element['duration']['text'] ?? null),
            'duration_value' => $element['duration_in_traffic']['value'] ?? ($element['duration']['value'] ?? null),
        ]);
    }
}
