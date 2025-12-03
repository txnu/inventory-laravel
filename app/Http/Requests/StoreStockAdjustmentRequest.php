<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockAdjustmentRequest extends FormRequest
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
            'product_id' => 'required|exists:products,product_id',
            'system_qty' => 'integer|nullable',
            'physical_qty' => 'integer|nullable',
            'difference' => 'integer|nullable',
            'reason' => 'string|nullable',
            'performed_by' => 'integer|exists:users,user_id',
        ];
    }
}
