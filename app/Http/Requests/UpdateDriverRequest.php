<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('driver');
        return [
            'user_id' => 'sometimes|exists:users,id',
            'license_number' => "sometimes|string|unique:drivers,license_number,$id",
            'phone' => 'sometimes|string',
            'profile_image' => 'nullable|string',
            'is_active' => 'boolean',
            'is_filed' => 'boolean',
        ];
    }
}
