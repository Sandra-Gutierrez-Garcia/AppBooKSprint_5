<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(UserRequest $request){
       $request->validated();
         $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        $user->roles()->attach(1);
        $token = $user->createToken('auth_token')->accessToken;

        return response([
            'token' => $token,
        ]);
            
    }
    public function login(LoginRequest $request){
        $request->validated();
        $user = User::where('email', $request->email)->first();

       if (!$user || !Hash::check($request->password, $user->password)) { 
        return response(['message' => 'Credenciales incorrectas'], 401);
    }

        $token = $user->createToken('auth_token')->accessToken;

        return response([
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(['message' => 'Sesión cerrada correctamente']);
    }
}


