<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:100',
            'content' => 'required|string|min:10|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'El título no puede tener más de 100 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.min' => 'El contenido debe tener al menos 10 caracteres.',
            'content.max' => 'El contenido no puede exceder los 1000 caracteres.',
        ];
    }
}
