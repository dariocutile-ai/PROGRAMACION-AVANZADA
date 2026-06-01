<?php

namespace App\Http\Requests\Suppliers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplier = $this->route('supplier');
        $supplierId = is_object($supplier) ? $supplier->id : $supplier;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('suppliers', 'name')->ignore($supplierId)],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('suppliers', 'email')->ignore($supplierId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
