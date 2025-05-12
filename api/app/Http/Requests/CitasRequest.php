<?php

namespace App\Http\Requests;

use App\Rules\MedicoRoleRule;
use App\Rules\HorarioPermitidoRule;
use Illuminate\Foundation\Http\FormRequest;

class CitasRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'user_id_medico' => ['required', 'exists:users,id', new MedicoRoleRule],
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => ['required', 'date_format:H:i', new HorarioPermitidoRule],
            'precio' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id_medico.required' => 'El campo médico es obligatorio.',
            'user_id_medico.exists' => 'El médico seleccionado no existe en el sistema.',
            'fecha.required' => 'El campo fecha es obligatorio.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o en una fecha futura.',
            'hora.required' => 'El campo hora es obligatorio.',
            'hora.date_format' => 'El campo hora debe tener el formato HH:MM.',
            'precio.required' => 'El campo precio es obligatorio.',
            'precio.numeric' => 'El campo precio debe ser un número.',
        ];
    }
}
