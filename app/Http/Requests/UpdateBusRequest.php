<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bus_number' => 'sometimes|string|unique:buses,bus_number,' . $this->route('bus'),
            'registration_id' => 'sometimes|string|unique:buses,registration_id,' . $this->route('bus'),
            'driver_id' => 'sometimes|exists:drivers,id',
            'route_id' => 'sometimes|exists:routes,id',
            'seating_capacity' => 'nullable|integer|min:1',
            'image_01' => 'nullable|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
