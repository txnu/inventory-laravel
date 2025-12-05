<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatesupplierRequest extends FormRequest
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
            'supplier_name' => 'string|required|max:100',
            'contact_name' => 'string|required|max:100',
            'email' => 'string|required',
            'phone' => 'numeric|required',
            'address' => 'string|required',
            'join_at' => 'date|required',
            'status' => 'boolean|required'
        ];
    }
}
