<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AuthController extends BaseApiController
{
    public function __construct(private readonly AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse

    {
        $token = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Registered successfully.',
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse

    {
        $token = $this->authService->login($request->validated());

        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request): JsonResponse

    {
        $this->authService->logout($request->user());


        return response()->json(['message' => 'Logged out.'], 204);
    }
}

