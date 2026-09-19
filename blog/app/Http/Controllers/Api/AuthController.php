<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterUserAction $registerUser,
        private readonly LoginUserAction $loginUser,
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json(
            $this->registerUser->execute($request->validated()),
            201,
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->loginUser->execute($request->validated()),
            200,
        );
    }
}
