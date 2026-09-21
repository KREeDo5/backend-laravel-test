<?php

namespace App\Http\Requests;

use App\Enums\PostSort;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListPostsRequest extends FormRequest
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
            'limit' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'offset' => ['sometimes', 'integer', 'min:0'],
            'sort' => ['sometimes', Rule::enum(PostSort::class)],
            'date_from' => ['sometimes', 'date'],
            'date_to' => ['sometimes', 'date', 'after_or_equal:date_from'],
        ];
    }

    public function attributes(): array
    {
        return [
            'limit' => 'Количество записей',
            'offset' => 'Смещение',
            'sort' => 'Сортировка',
            'date_from' => 'Дата от (фильтрация)',
            'date_to' => 'Дата до (фильтрация)',
        ];
    }

    public function messages(): array
    {
        return [
            'limit.integer' => 'Количество записей должно быть целым числом',
            'limit.min' => 'Количество записей должно быть не менее :min',
            'limit.max' => 'Количество записей должно быть не более :max',
            'offset.integer' => 'Смещение должно быть целым числом',
            'offset.min' => 'Смещение должно быть не менее :min',
            'sort' => 'Недопустимое значение сортировки. Допустимые значения: ' . implode(', ', PostSort::values()) . '.',
            'date_from.date' => 'Дата от (фильтрация) указана в неверном формате.',
            'date_to.date' => 'Дата до (фильтрация) указана в неверном формате.',
            'date_to.after_or_equal' => 'Дата до (фильтрация) должна быть не раньше даты от.',
        ];
    }
}
