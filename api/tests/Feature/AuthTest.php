<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /** @test */
    public function usuario_puede_loguearse_con_credenciales_correctas()
    {
        $correo = 'prueba@example.com';
        $clave = 'password123';

        $user = User::where('email', $correo)->first();

        if( is_null($user) ) {
            $user = User::create([
                'name' => 'Prueba',
                'email' => $correo,
                'password' => $clave,
            ]);

            $user->assignRole('paciente');
        }

        // Consumir el endpoint de login
        $response = $this->postJson('/api/auth/login', [
            'correo' => $correo,
            'clave' => $clave,
        ]);
        
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'code',
            'message',
            'data' => [
                'token',
            ]
        ]);
    }
}
