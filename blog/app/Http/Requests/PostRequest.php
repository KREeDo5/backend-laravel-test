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
            // Ограничение длины (16383) связано с весом символов, 
            // которые могут занимать до 4 байт. (65535/4=16383,75)
            'text' => ['required', 'string', 'max:16383'],
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
            'text.max' => 'Текст публикации не должен превышать :max символов.',
        ];
    }
}
