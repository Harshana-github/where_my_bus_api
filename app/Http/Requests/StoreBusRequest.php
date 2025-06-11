<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bus_number' => 'required|string|unique:buses,bus_number',
            'registration_id' => 'required|string|unique:buses,registration_id',
            'driver_id' => 'required|exists:drivers,id',
            'route_id' => 'required|exists:routes,id',
            'seating_capacity' => 'nullable|integer|min:1',
            'image_01' => 'nullable|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
