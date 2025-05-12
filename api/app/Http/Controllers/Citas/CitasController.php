<?php

namespace App\Http\Controllers\Citas;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CitasRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CitaCollection;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class CitasController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:paciente'])->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CitasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CitasRequest $request)
    {
        $paciente = auth()->user();

        $medico = User::find($request->user_id_medico);

        $existe = $medico->citasMedico()
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($existe) {
            return ResponseBuilder::asError(422)
                ->withHttpCode(422)
                ->withMessage('El médico ya tiene una cita agendada en ese horario.')
                ->build();
        }

        $cita = (new CitaCollection(Cita::create([
            'paciente_id' => $paciente->id,
            'medico_id' => $request->user_id_medico,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado_id' => 1,
            'confirmacion' => false,
            'precio' => $request->precio,
        ])))->toArray(request());

        return ResponseBuilder::asSuccess(201)
            ->withHttpCode(201)
            ->withMessage('Cita creada correctamente')
            ->withData($cita)
            ->build();
    }
}
