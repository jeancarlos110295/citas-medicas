<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'estado_id',
        'fecha',
        'hora',
        'confirmacion',
        'precio',
    ];

    /**
     * Relación muchos a uno:
     * Obtiene el usuario que actúa como paciente en esta cita.
     */
    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    /**
     * Relación muchos a uno:
     * Obtiene el usuario que actúa como médico en esta cita.
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
}