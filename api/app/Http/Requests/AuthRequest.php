<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'correo' => 'required|string|email|max:255',
            'clave' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección de correo electrónico válida.',
            'clave.required' => 'La clave es obligatoria.',
            'clave.min' => 'La clave debe tener al menos 8 caracteres.',
        ];
    }
}
