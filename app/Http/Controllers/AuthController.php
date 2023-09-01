<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgistroRuquest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(ResgistroRuquest $resquest)
    {
        $user = User::create([
            'name' => $resquest->name,
            'email' => $resquest->email,
            'password' => bcrypt($resquest->password),
        ]);

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user,
        ];
    }

    public function login(Request $resquest)
    {

    }

    public function logout(Request $resquest)
    {

    }
}
