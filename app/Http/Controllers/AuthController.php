<?php

namespace App\Http\Controllers;


use App\Http\Requests\Login\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Usuário e/ou senha inválido(s)!'], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('API Token', ['park-api'])->plainTextToken;

            return response()->json(['token' => $token]);
        } catch (\Exception $th) {
            dd($th->getMessage());
            return response()->json(['error' => 'Erro ao logar'], 500);
        }
    }

}
