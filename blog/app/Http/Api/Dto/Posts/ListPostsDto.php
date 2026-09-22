<?php

namespace App\Http\Api\Dto\Posts;

use App\Enums\PostSort;
use App\Http\Api\Dto\Base\ListDto;

final readonly class ListPostsDto
{
    /** Сортировка по умолчанию: новые посты - первые */
    public const PostSort DEFAULT_SORT = PostSort::DateDesc;

    public function __construct(
        public ListDto $list,
        public PostSort $sort = self::DEFAULT_SORT,
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
    ) {
    }
}
