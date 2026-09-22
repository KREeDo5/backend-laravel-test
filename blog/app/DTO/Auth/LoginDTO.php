<?php

namespace App\DTO\Auth;

/**
 * Данные для авторизации пользователя.
 */
final readonly class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
