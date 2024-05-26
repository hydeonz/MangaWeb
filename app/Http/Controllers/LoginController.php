<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function attempt(Request $request)
    {
        $credentials = $request->only('email', 'password');;
        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Вы успешно вошли в систему'], 200);
        }
        return response()->json(['message' => 'Неверный email или пароль'], 401);
    }
    public function logout()
    {
        Auth::logout();
        return Redirect::route('home');
    }
}
