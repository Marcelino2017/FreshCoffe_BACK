<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgistroRuquest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(ResgistroRuquest $resquest) {
        $data = $resquest->validate();
    }

    public function login(Request $resquest) {

    }

    public function logout(Request $resquest) {

    }
}
