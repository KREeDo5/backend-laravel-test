<?php

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserService
{
    /**
     * bcrypt-хэш случайной строки.
     */
    private const DUMMY_HASH = '$2y$12$VUk/UGH6yKjPM6i2QsQuTuKeaWkTHMKR8LiABinrltDcwG7m9/S3G';

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        // Проверка хэша выполняется ВСЕГДА (и для несуществующего email тоже),
        // иначе время 401-ответа раскрывает существование email.
        $hash = $user?->password ?? self::DUMMY_HASH;
        $passwordMatches = Hash::check($data['password'], $hash);

        if (! $user || ! $passwordMatches) {
            throw new ApiException('Неверный email или пароль.', 401);
        }

        return ['user' => $user, 'accessToken' => $user->generateToken()];
    }
}