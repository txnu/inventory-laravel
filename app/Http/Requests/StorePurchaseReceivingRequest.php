<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseReceivingRequest extends FormRequest
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
            'po_id' => 'required|exists:purchase_orders,po_id',
            'receiving_date' => 'date|required',
            'supplier_id' => 'integer|required|exists:users,user_id',
            'items' => 'required|array|min:1',
            'items.*.po_item_id' => 'required|exists:purchase_order_items,po_item_id',
            'items.*.product_id' => 'nullable|exists:products,product_id',
            'items.*.qty_received_now' => 'required|integer|min:1',
            'items.*.note' => 'string|nullable',
        ];
    }
}
