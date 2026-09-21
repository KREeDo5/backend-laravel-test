<?php

namespace App\Http\Requests;

use App\Rules\EmailRegex;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Регистрация доступна для всех
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'max:255', 'unique:users', new EmailRegex],
            'password' => ['required', 'string', 'min:4'],
        ];
    }

    public function attributes(): array
    {
        // Имена полей — для текста ошибок
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Требуется указать имя.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать :max символов.',
            'email.required' => 'Требуется указать email.',
            'email.max' => 'Email не должен превышать :max символов.',
            'email.unique' => 'Пользователь с указанным email уже зарегистрирован.',
            'password.required' => 'Требуется указать пароль.',
            'password.string' => 'Пароль должен быть строкой.',
            'password.min' => 'Пароль должен содержать не менее :min символов.',
        ];
    }
}
