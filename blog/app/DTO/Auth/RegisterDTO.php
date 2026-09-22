<?php

namespace App\DTO\Auth;

/**
 * Данные для регистрации пользователя.
 */
final readonly class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
