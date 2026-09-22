<?php

namespace App\DTO\Posts;

final readonly class CreatePostDTO
{
    public function __construct(
        public string $title,
        public string $text,
    ) {
    }
}
