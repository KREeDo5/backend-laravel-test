<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;

class RegisterUserService
{
    public function create(array $data): array
    {
        try {
            $user = User::create($data);
        } catch (UniqueConstraintViolationException) {
            throw new ApiException('Пользователь с таким email уже зарегистрирован.', 409);
        }

        return ['user' => $user, 'accessToken' => $user->generateToken()];
    }
}