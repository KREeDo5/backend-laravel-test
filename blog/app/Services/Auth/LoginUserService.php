<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new ApiException('Неверный email или пароль.', 401);
        }

        return ['user' => $user, 'accessToken' => $user->generateToken()];
    }
}