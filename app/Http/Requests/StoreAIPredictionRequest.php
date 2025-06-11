<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAIPredictionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bus_id'                 => 'required|exists:buses,id',
            'predicted_arrival_time' => 'required|numeric|min:0',
            'distance'              => 'required|numeric|min:0',
            'speed'                 => 'required|numeric|min:0',
            'traffic_condition'     => 'required|string|max:255',
        ];
    }
}
