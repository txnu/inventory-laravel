<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_code' => 'string|required|max:50',
            'warehouse_name' => 'string|required|max:100',
            'description' => 'string',
            'country' => 'string',
            'province' => 'string',
            'city' => 'string',
            'postal_code' => 'string',
            'address' => 'string',
            'contact_person' => 'string',
            'contact_phone' => 'string',
            'is_active' => 'boolean|required'
        ];
    }
}
