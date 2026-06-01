<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var int|string|null $category */
        $category = $this->route('category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:categories,name,' . $category . ',id'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ya existe una categoría con ese nombre.',
        ];
    }
}

