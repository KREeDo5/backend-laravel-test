<?php

namespace App\Actions\Posts;

use App\Models\Post;
use App\Models\User;

class CreatePostAction
{

    public function execute(User $author, array $data): Post
    {
        return Post::create([
            // Id автора — берётся по токену доступа
            'author_id' => $author->id,
            'title' => $data['title'],
            'body' => $data['text'],
        ]);
    }
}