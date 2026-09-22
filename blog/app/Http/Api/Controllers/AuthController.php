<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
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

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Регистрация нового пользователя",
     *
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Иван Петров"),
     *             @OA\Property(property="email", type="string", format="email", maxLength=255, example="ivan@petrov.ru"),
     *             @OA\Property(property="password", type="string", minLength=4, example="12345678"),
     *         ),
     *     ),
     *
     *     @OA\Response(response=201, description="Успешная регистрация",
     *         @OA\JsonContent(ref="#/components/schemas/AuthResponse"),
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации (email занят, не проходит проверку формата и т.д.)",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->registerUserService->create($request->toDTO());

        return response()->json([
            'user' => new UserResource($result['user']),
            'accessToken' => $result['accessToken'],
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Профиль пользователя и accessToken",
     *
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@test.test"),
     *             @OA\Property(property="password", type="string", example="1234"),
     *         ),
     *     ),
     *
     *     @OA\Response(response=200, description="Успешная авторизация",
     *         @OA\JsonContent(ref="#/components/schemas/AuthResponse"),
     *     ),
     *     @OA\Response(response=401, description="Неверный email или пароль",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->loginUserService->login($request->toDTO());

        return response()->json([
            'user' => new UserResource($result['user']),
            'accessToken' => $result['accessToken'],
        ], 200);
    }
}
