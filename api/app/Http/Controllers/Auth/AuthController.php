<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class AuthController extends Controller
{
    public function login(AuthRequest $request){
        $user = User::where('email', $request->correo)->first();

        if ( !$user || !Hash::check($request->clave, $user->password) ) {
            return ResponseBuilder::asError(401)
                ->withHttpCode(401)
                ->withMessage('Credenciales inválidas.')
                ->build();
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return ResponseBuilder::asSuccess(200)
            ->withHttpCode(200)
            ->withMessage('Usuario autenticado correctamente.')
            ->withData([
                'id_user' => $user->id,
                'nombre' => $user->name,
                'correo' => $user->email,
                'token' => 'Bearer '.$token,
                'role' => $user->getRoleNames(),
            ])->build();
    }
}