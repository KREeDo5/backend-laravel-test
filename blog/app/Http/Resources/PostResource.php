<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Сериализация публикации для API-ответов.
 *
 * @OA\Schema(
 *     schema="Post",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Заголовок публикации"),
 *     @OA\Property(property="body", type="string", example="Текст публикации"),
 *     @OA\Property(property="author", type="object", nullable=true,
 *         description="Автор; присутствует, если загружена связь",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Иван Петров"),
 *     ),
     *     @OA\Property(property="created_at", type="integer", example=1789000000),
 * )
 */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'author' => $this->whenLoaded('author', fn () => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ]),
            'created_at' => $this->created_at->getTimestamp(),
        ];
    }
}