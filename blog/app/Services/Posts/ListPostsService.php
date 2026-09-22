<?php

namespace App\Services\Posts;

use App\DTO\Posts\ListPostsDTO;
use App\Enums\PostSort;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ListPostsService
{
    public function list(ListPostsDTO $dto, ?User $author = null): Collection
    {
        $postQuery = Post::query()
            ->with('author:id,name');

        $this->applyFilters($postQuery, $dto, $author);

        // Сортировка и пагинация
        $this->applySort($postQuery, $dto->sort);
        $this->applyPagination($postQuery, $dto);

        return $postQuery->get();
    }

    private function applyFilters(Builder $postQuery, ListPostsDTO $dto, ?User $author): void
    {
        $this->applyUser($postQuery, $author);
        $this->applyDates($postQuery, $dto);
        // Точка расширения для фильтров
    }

    private function applyUser(Builder $postQuery, ?User $author): void
    {
        $postQuery->when($author !== null, fn (Builder $query) => $query->where(['author_id' => $author->id]));
    }

    private function applyDates(Builder $postQuery, ListPostsDTO $dto): void
    {
        $postQuery
            ->when($dto->dateFrom !== null, fn (Builder $query) => $query->where('created_at', '>=', Carbon::parse($dto->dateFrom)->startOfDay()))
            ->when($dto->dateTo !== null, fn (Builder $query) => $query->where('created_at', '<=', Carbon::parse($dto->dateTo)->endOfDay()));
    }

     private function applySort(Builder $query, PostSort $sort): void
    {
        [$column, $direction] = match ($sort) {
            PostSort::TitleAsc => ['title', 'asc'],
            PostSort::TitleDesc => ['title', 'desc'],
            PostSort::DateAsc => ['created_at', 'asc'],
            PostSort::DateDesc => ['created_at', 'desc'],
            default => ['created_at', 'desc'],
        };

        $query->orderBy($column, $direction);
    }

    private function applyPagination(Builder $postQuery, ListPostsDTO $dto): void
    {
        if ($dto->limit !== null) {
            $postQuery->limit($dto->limit);
        }
        if ($dto->offset !== null) {
            $postQuery->offset($dto->offset);
        }
    }
}