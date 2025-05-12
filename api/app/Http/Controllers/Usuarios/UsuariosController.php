<?php

namespace App\Http\Controllers\Usuarios;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Http\Resources\UserCollection;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class UsuariosController extends Controller
{    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        $user = User::create([
            'name' => $request->nombre, 
            'email' => $request->correo,
            'password' => $request->clave,
        ]);

        $user->assignRole($request->role);

        return ResponseBuilder::asSuccess(201)
            ->withHttpCode(201)
            ->withMessage('Usuario creado correctamente')
            ->withData(
                (new UserCollection( $user ))->toArray(request())
            )
            ->build();
    }
}
