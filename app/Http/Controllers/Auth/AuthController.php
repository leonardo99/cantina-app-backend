<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!$token = JWTAuth::attempt($data)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()
            ->json(['message' => 'Login bem-sucedido'])
            ->cookie('token', $token, 120, '/', null, false, true);
    }

    public function user()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return new UserResource($user);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()
            ->json(['message' => 'Logout efetuado'], 200)
            ->withCookie(cookie()->forget('token'));
    }
}
