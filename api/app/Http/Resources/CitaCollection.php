<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CitaCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id_cita' => (int) $this->id,
            'user_id_medico' => (int) $this->medico_id,
            'user_id_paciente' => (int) $this->paciente_id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'estado' => (int) $this->estado_id,
            'confirmacion' => $this->confirmacion,
            'precio' => (float) $this->precio,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
