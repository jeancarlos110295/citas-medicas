<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(AuthRequest $request){
        $user = User::where('email', $request->correo)->first();

        if ( !$user || !Hash::check($request->clave, $user->password) ) {
            return $this->errorResponse('Credenciales inválidas', 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'id_user' => $user->id,
            'nombre' => $user->name,
            'correo' => $user->email,
            'token' => $token,
            'role' => $user->getRoleNames(),
        ], 200);
    }
}