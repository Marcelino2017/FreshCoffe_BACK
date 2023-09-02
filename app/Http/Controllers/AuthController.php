<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResgistroRuquest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(ResgistroRuquest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user,
        ];
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, true)) {
            return response([
                'errors' => ['El email o  el password son incorrectos']
            ], 422);
        }

        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user,
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        //Revocar el token de acceso actual del usuario
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
