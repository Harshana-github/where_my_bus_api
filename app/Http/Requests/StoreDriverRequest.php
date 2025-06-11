<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'license_number' => 'required|string|unique:drivers,license_number',
            'phone' => 'required|string',
            'profile_image' => 'nullable|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
