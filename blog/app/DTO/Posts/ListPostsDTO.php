<?php

namespace App\DTO\Posts;

use App\Enums\PostSort;

final readonly class ListPostsDTO
{
    public const DEFAULT_SORT = PostSort::DateDesc;

    public function __construct(
        public ?int $limit = null,
        public ?int $offset = null,
        public PostSort $sort = self::DEFAULT_SORT,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
    ) {
    }
}
