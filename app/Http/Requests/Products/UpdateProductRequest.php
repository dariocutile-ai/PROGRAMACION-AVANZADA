<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeProduct = $this->route('product');
        $productId = is_object($routeProduct) ? $routeProduct->id : (int) ($this->route('id') ?? $routeProduct);

        return [
            'sku' => ['sometimes', 'required', 'string', 'max:60', 'unique:products,sku,' . $productId],
            'name' => ['sometimes', 'required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:10000'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'supplier_id' => ['sometimes', 'required', 'exists:suppliers,id'],
            'stock' => ['sometimes', 'required', 'integer', 'min:0'],
            'reorder_level' => ['sometimes', 'required', 'integer', 'min:0'],
            'purchase_price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'sale_price' => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
