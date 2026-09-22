<?php

namespace App\Http\Requests;

use App\Http\Api\Dto\Auth\LoginDto;
use App\Http\Api\Dto\Contracts\HasDTO;
use App\Rules\EmailRegex;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRequest extends ApiRequest implements HasDTO
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

    public function toDTO(): LoginDto
    {
        return LoginDto::fromArray($this->validated());
    }
}
