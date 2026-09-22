<?php

namespace App\Http\Requests;

use App\DTO\Auth\LoginDTO;
use App\DTO\Contracts\HasDTO;
use App\Rules\EmailRegex;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest implements HasDTO
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', new EmailRegex],
            'password' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Требуется указать email.',
            'password.required' => 'Требуется указать пароль.',
        ];
    }

    public function toDTO(): LoginDTO
    {
        $data = $this->validated();

        return new LoginDTO(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
