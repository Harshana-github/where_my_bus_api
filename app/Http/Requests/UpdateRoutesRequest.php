<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoutesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('route');
        return [
            'route_name' => "sometimes|string|unique:routes,route_name,{$id}",
            'start_location' => 'sometimes|string',
            'end_location' => 'sometimes|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
