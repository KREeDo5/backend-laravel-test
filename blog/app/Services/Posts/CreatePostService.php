<?php

namespace App\Services\Posts;

use App\DTO\Posts\CreatePostDTO;
use App\Models\Post;
use App\Models\User;

class CreatePostService
{

    public function create(User $author, CreatePostDTO $dto): Post
    {
        return Post::create([
            // Id автора — берётся по токену доступа
            'author_id' => $author->id,
            'title' => $dto->title,
            'body' => $dto->text,
        ]);
    }
}