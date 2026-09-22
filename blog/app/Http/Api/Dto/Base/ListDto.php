<?php

namespace App\Http\Api\Dto\Base;

final readonly class ListDto
{
    public function __construct(
        public ?int $limit = null,
        public ?int $offset = null,
    ) {
    }
}
