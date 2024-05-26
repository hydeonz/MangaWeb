<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $json = $request->all();

        $userExists = DB::table('users')
            ->where('email', $json['email'])
            ->exists();

        if ($userExists) {
            return response()->json(['message' => 'Данный пользователь уже зарегистрирован'], 400);
        }

        try {
            DB::table('users')->insert([
                'name' => $json['name'],
                'email' => $json['email'],
                'password' => Hash::make($json['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Вы успешно зарегистрировались!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Произошла внутренняя ошибка, попробуйте позже'], 500);
        }
    }

}
