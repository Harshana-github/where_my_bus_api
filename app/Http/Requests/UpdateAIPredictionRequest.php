<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAIPredictionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bus_id'              => 'sometimes|exists:buses,id',
            'predicted_arrival_time' => 'sometimes|numeric|min:0',
            'distance'            => 'sometimes|numeric|min:0',
            'speed'               => 'sometimes|numeric|min:0',
            'traffic_condition'   => 'sometimes|string|max:255',
            'prediction_timestamp' => 'sometimes|date',
        ];
    }
}
