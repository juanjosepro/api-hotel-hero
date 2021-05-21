<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    //use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => 'required|string',
            'password' => 'required|string',
        ]);

    	if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            if (Auth::user()->status === "enabled") {
                return Auth::user();
            }
            return response()->json([
                "errorMsg" => "Usuario Inhabilitado! no puedes acceder al sistema."
            ]);
    	}
    	return response()->json([
    	    "errorMsg" => "Estas credenciales no coinciden con nuestros registros."
        ]);
    }
    public function logout( Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(null);
    }
}
