<?php

namespace App\Rules;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Rule;

class HorarioPermitidoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $hora = Carbon::createFromFormat('H:i', $value);

            $rangos = config('citas.horarios_permitidos');

            foreach ($rangos as $rango) {
                $inicio = Carbon::createFromFormat('H:i', $rango['inicio']);
                $fin = Carbon::createFromFormat('H:i', $rango['fin']);

                if ($hora->between($inicio, $fin)) {
                    return true;
                }
            }
            
            return false;
        } catch (Exception $e) {
            Log::error('Error al validar la hora: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La hora de la cita debe estar entre 07:00-12:00 o 14:00-18:00.';
    }
}
