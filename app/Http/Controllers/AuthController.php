<?php

namespace App\Http\Controllers;

use App\Events\NewUserRegister;
use App\Helper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['register_number'] = Helper::RegisterNumber();
        $user = $this->userRepository->store($data);

        NewUserRegister::dispatch($user);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
