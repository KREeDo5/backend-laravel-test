<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Права проверяет middleware
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
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Название публикации',
            'text' => 'Текст публикации',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Требуется указать название публикации.',
            'title.max' => 'Название публикации не должно превышать :max символов.',
            'text.required' => 'Требуется указать текст публикации.',
        ];
    }
}
