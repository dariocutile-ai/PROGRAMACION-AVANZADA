<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryMovementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'type' => ['required', 'string', 'in:purchase,restock,sale,waste'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:2000'],

            // opcional (para compras/ventas reales en el futuro)
            'reference_type' => ['nullable', 'string', 'max:100'],
            'reference_id' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'El tipo de movimiento no es válido.',
        ];
    }
}

