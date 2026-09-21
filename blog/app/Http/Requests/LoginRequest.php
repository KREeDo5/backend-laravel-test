<?php

namespace App\Http\Requests;

use App\Rules\EmailRegex;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         // Авторизация доступна для всех
        return true;
    }

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
}
