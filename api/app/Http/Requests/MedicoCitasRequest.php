<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoCitasRequest extends FormRequest
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
    public function rules() : array
    {
        return [
            'estado_id' => 'required|integer|exists:estados,id',
        ];
    }

    public function messages() : array
    {
        return [
            'estado_id.required' => 'El campo estado_id es obligatorio.',
            'estado_id.integer' => 'El campo estado_id debe ser un número entero.',
            'estado_id.exists' => 'El estado seleccionado no es válido.',
        ];
    }
}
