<?php

namespace App\Http\Api\Dto\Auth;

final readonly class RegisterDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

    public static function fromArray(array $data): RegisterDto
    {
        return new RegisterDto(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );
    }
}
