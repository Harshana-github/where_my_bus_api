<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTownRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $name = is_string($this->name) ? trim($this->name) : $this->name;

        $this->merge([
            'name'       => $name,
            'is_active'  => filter_var($this->is_active, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE),
            'latitude'   => is_null($this->latitude) ? null : (float) $this->latitude,
            'longitude'  => is_null($this->longitude) ? null : (float) $this->longitude,
        ]);
    }

    public function rules(): array
    {
        // Works with route model binding: towns/{town}
        $town = $this->route('town'); // Town model or id

        return [
            'name'       => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('towns', 'name')->ignore(is_object($town) ? $town->id : $town),
            ],
            'is_active'  => ['sometimes', 'boolean'],
            'latitude'   => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => 'town name',
            'latitude'  => 'latitude',
            'longitude' => 'longitude',
        ];
    }
}
