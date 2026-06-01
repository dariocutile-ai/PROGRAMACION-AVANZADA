<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Regla académica: todos los roles autenticados pueden crear comentarios.
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'min:3', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'El contenido del comentario es obligatorio.',
            'content.string' => 'El contenido del comentario debe ser texto.',
            'content.min' => 'El comentario debe tener al menos :min caracteres.',
            'content.max' => 'El comentario no debe exceder :max caracteres.',
        ];
    }
}

