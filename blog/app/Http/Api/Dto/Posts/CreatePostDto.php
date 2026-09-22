<?php

namespace App\Http\Api\Dto\Posts;

final readonly class CreatePostDto
{
    public function __construct(
        public string $title,
        public string $text,
    ) {
    }

    public static function fromArray(array $data): CreatePostDto
    {
        return new CreatePostDto(
            title: $data['title'],
            text: $data['text'],
        );
    }
}
