<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class JwtAuthController extends Controller
{
    public function authenticate(Request $request): Object
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->responseWithToken($token);
    }

    public function refreshToken(Request $request): Object
    {
        if (!auth()->check()) {
            return $this->responseWithToken(auth()->refresh());
        }

        return $this->responseWithToken($request->bearerToken());
    }

    private function responseWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
