<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\LoginUserService;
use App\Services\Auth\RegisterUserService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterUserService $registerUserService,
        private readonly LoginUserService $loginUserService,
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json(
            $this->registerUserService->create($request->validated()),
            201,
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->loginUserService->login($request->validated()),
            200,
        );
    }
}
