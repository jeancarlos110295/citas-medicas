<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,email',
            'clave' => 'required|string|min:8',
            'role' => 'required|string|in:medico,paciente',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser una dirección de correo electrónico válida.',
            'correo.unique' => 'El correo ya está en uso.',
            'clave.required' => 'La clave es obligatoria.',
            'clave.min' => 'La clave debe tener al menos 8 caracteres.',
            'role.required' => 'El rol es obligatorio.',
            'role.in' => 'El rol debe ser uno de los siguientes: medico, cliente.',
        ];
    }
}
