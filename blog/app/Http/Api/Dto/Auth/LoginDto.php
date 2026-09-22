<?php

namespace App\Http\Api\Dto\Auth;

final readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }

    public static function fromArray(array $data): LoginDto
    {
        return new LoginDto(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
