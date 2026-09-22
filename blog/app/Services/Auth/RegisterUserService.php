<?php

namespace App\Services\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegisterUserService
{
    public function create(RegisterDTO $dto): array
    {
        try {
            return DB::transaction(function () use ($dto): array {
                $user = User::create([
                    'name' => $dto->name,
                    'email' => $dto->email,
                    'password' => $dto->password,
                ]);

                return ['user' => $user, 'accessToken' => $user->generateToken()];
            });
        } catch (UniqueConstraintViolationException) {
            throw new ApiException('Пользователь с таким email уже зарегистрирован.', 409);
        } catch (Throwable) {
            throw new ApiException('Не удалось зарегистрировать пользователя, попробуйте позже.', 500);
        }
    }
}