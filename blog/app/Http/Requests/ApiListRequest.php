<?php

namespace App\Http\Requests;

use App\Http\Api\Dto\Base\ListDto;

abstract class ApiListRequest extends ApiRequest
{
    public function rules(): array
    {
        $this->mergeIfMissing([
            'offset' => 0,
        ]);

        return [
            'limit' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'offset' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function toBaseDto(): ListDto
    {
        $data = $this->validated();

        return new ListDto(
            limit: isset($data['limit']) ? (int) $data['limit'] : null,
            offset: isset($data['offset']) ? (int) $data['offset'] : null,
        );
    }
}
