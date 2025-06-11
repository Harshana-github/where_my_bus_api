<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'user_type' => 'required|in:driver,passenger',
            'password' => 'required|min:6',
            'is_profile_completed' => 'boolean',
        ];
    }
}
