<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Blog API",
 *     version="1.0.0",
 *     description="Тестовое задание «Блог»"
 * )
 * @OA\Server(
 *     url="/",
 *     description=""
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     description="accessToken"
 * )
 *
 * @OA\Schema(
 *     schema="Meta",
 *     description="Метаданные ответа (TransformApiResponse)",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="")
 * )
 * @OA\Schema(
 *     schema="AuthResponse",
 *     description="Ответ регистрации и авторизации",
 *     @OA\Property(property="meta", ref="#/components/schemas/Meta"),
 *     @OA\Property(property="data", type="object",
 *         @OA\Property(property="user", ref="#/components/schemas/User"),
 *         @OA\Property(property="accessToken", type="string", example="1|aBcDeFgHiJkLmNoPqRsTuVwXyZ0123456789")
 *     )
 * )
 * @OA\Schema(
 *     schema="PostListResponse",
 *     description="Лента публикаций (одна порция)",
 *     @OA\Property(property="meta", ref="#/components/schemas/Meta"),
 *     @OA\Property(property="data", type="array",
 *         @OA\Items(ref="#/components/schemas/Post")
 *     )
 * )
 * @OA\Schema(
 *     schema="PostResponse",
 *     description="Созданная публикация",
 *     @OA\Property(property="meta", ref="#/components/schemas/Meta"),
 *     @OA\Property(property="data", ref="#/components/schemas/Post")
 * )
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     description="Ошибка (валидация 422, аутентификация 401)",
 *     @OA\Property(property="meta", ref="#/components/schemas/Meta"),
 *     @OA\Property(property="data", type="object", example={})
 * )
 */
class OpenApi
{
}
