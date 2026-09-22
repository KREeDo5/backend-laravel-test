<?php

namespace App\Http\Requests;

use App\Enums\PostSort;
use App\Http\Api\Dto\Contracts\HasDTO;
use App\Http\Api\Dto\Posts\ListPostsDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class ListPostsRequest extends ApiListRequest implements HasDTO
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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

    public function toDTO(): ListPostsDto
    {
        $data = $this->validated();

        return new ListPostsDto(
            list: $this->toBaseDto(),
            sort: isset($data['sort']) ? PostSort::from($data['sort']) : ListPostsDto::DEFAULT_SORT,
            dateFrom: $data['date_from'] ?? null,
            dateTo: $data['date_to'] ?? null,
        );
    }
}
