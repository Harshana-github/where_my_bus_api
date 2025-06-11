<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoutesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'route_name' => 'required|string|unique:routes,route_name',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
