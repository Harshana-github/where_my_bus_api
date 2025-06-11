<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\DataLayer\AuthDataLayer;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authDL;
    public function __construct(AuthDataLayer $authDL)
    {
        $this->authDL = $authDL;
    }

    public function register(UserRegisterRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
            'user_type' => 'required|string|in:admin,user,passenger,driver'
        ]);;
        try {
            $user = $this->authDL->insert($validatedData);
            $token = auth('api')->login($user);

            return response([
                'user' => $user,
                'token' => $this->respondWithToken($token)
            ]);
        } catch (QueryException $ex) {
            Log::error('User registration failed: ' . $ex->getMessage());
            return response()->json(['error' => 'User registration failed'], 500);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user()->load(['driver.buses.route']);

        return response([
            'user' => $user,
            'token' => $this->respondWithToken($token)
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
