<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Nombre del rol paciente
     * @var string
     */
    const NAME_ROL_PACIENTE = 'paciente';

    /**
     * Nombre del rol medico
     * @var string
     */
    const NAME_ROL_MEDICO = 'medico';


    protected function getDefaultGuardName(): string { 
        return 'sanctum'; 
    }

    public function guardName(): array { 
        return ['sanctum']; 
    }
    
    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relación uno a muchos:
     * Obtiene todas las citas en las que el usuario actúa como paciente.
     */
    public function citasPacientes()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    /**
     * Relación uno a muchos:
     * Obtiene todas las citas en las que el usuario actúa como médico.
     */
    public function citasMedico()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }
}
