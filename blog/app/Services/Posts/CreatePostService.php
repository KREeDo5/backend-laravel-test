<?php

namespace App\Services\Posts;

use App\Http\Api\Dto\Posts\CreatePostDto;
use App\Models\Post;
use App\Models\User;

class CreatePostService
{

    public function create(User $author, CreatePostDto $dto): Post
    {
        return Post::create([
            // Id автора — берётся по токену доступа
            'author_id' => $author->id,
            'title' => $dto->title,
            'body' => $dto->text,
        ]);
    }
}