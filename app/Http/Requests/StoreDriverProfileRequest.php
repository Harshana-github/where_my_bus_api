<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Driver
            'driver.user_id' => 'required|exists:users,id',
            'driver.license_number' => 'required|string|unique:drivers,license_number',
            'driver.phone' => 'required|string',
            'driver.profile_image' => 'nullable|string',
            'driver.is_active' => 'boolean',
            'driver.is_filed' => 'boolean',

            // Route
            'route.route_name' => 'required|string|unique:routes,route_name',
            'route.start_location' => 'required|string',
            'route.end_location' => 'required|string',
            'route.is_active' => 'boolean',
            'route.is_filed' => 'boolean',

            // Bus
            'bus.bus_number' => 'required|string|unique:buses,bus_number',
            'bus.registration_id' => 'required|string|unique:buses,registration_id',
            'bus.seating_capacity' => 'nullable|integer|min:1',
            'bus.image_01' => 'nullable|string',
            'bus.is_active' => 'boolean',
            'bus.is_filed' => 'boolean',
        ];
    }
}
