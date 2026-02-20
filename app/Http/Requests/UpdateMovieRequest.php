<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            'titulo' => 'sometimes|required|string|max:255',
            'director' => 'sometimes|required|string|max:255',
            'anio' => 'sometimes|required|digits:4|integer|min:1888|max:' . date('Y'),
            'duracion' => 'nullable|integer|min:1',
            'genero' => 'sometimes|required|string|max:255',
            'sinopsis' => 'nullable|string',
            'reparto' => 'nullable|string|max:255',
            'pais' => 'sometimes|required|string|max:255',
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'clasificacion_edad' => 'nullable|string|max:50',
            'valoracion_media' => 'nullable|numeric|between:0,9.99',
            'user_id' => 'sometimes|required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'director.required' => 'El director es obligatorio.',
            'anio.required' => 'El año es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero.',
            'genero.required' => 'El género es obligatorio.',
            'pais.required' => 'El país es obligatorio.',
        ];
    }
}
