<?php

namespace App\Http\Controllers\Medico;

use Carbon\Carbon;
use App\Models\Cita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CitaCollection;
use App\Http\Requests\MedicoCitasRequest;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class MedicoCitasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:medico']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medico = auth()->user();

        $citas = Cita::with(['paciente', 'medico'])
            ->where('medico_id', $medico->id)
            ->whereDate('fecha', Carbon::today())
            ->orderBy('hora', 'asc')
            ->get();

        return ResponseBuilder::asSuccess()
            ->withMessage('Citas del día listadas correctamente.')
            ->withData( CitaCollection::collection($citas) )
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cita $medicocita)
    {
        return ResponseBuilder::asSuccess()
            ->withMessage('Citas del día listadas correctamente.')
            ->withData( (new CitaCollection($medicocita))->toArray(request()) )
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MedicoCitasRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicoCitasRequest $request, Cita $medicocita)
    {
        if( $request->has('estado_id') ){
            $medicocita->estado_id = $request->estado_id;

            /**
             * Si el pago es aceptado o confirmado, se cambia el estado de confirmación a true
             */
            if(  in_array($request->estado_id , [2,3]) ){
                $medicocita->confirmacion = true;
            }else{
                $medicocita->confirmacion = false;
            }
        }

        $medicocita->save();

        return ResponseBuilder::asSuccess()
            ->withMessage('Cita actualizada correctamente.')
            ->withData( (new CitaCollection($medicocita))->toArray(request()) )
            ->build();
    }
}
