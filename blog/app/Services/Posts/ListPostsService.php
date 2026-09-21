<?php

namespace App\Services\Posts;

use App\Enums\PostSort;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ListPostsService
{
    /** Сортировка по умолчанию: новые посты - первые */
    private const DEFAULT_SORT = PostSort::DateDesc;

    private const SORT_COLUMNS = [
        PostSort::TitleAsc->value => ['column' => 'title', 'direction' => 'asc'],
        PostSort::TitleDesc->value => ['column' => 'title', 'direction' => 'desc'],
        PostSort::DateAsc->value => ['column' => 'created_at', 'direction' => 'asc'],
        PostSort::DateDesc->value => ['column' => 'created_at', 'direction' => 'desc'],
    ];

    public function list(array $filters, ?User $author = null): Collection
    {
        $sort = $this->resolveSort($filters);

        $postQuery = Post::query()
            ->with('author:id,name');

        $this->applyFilters($postQuery, $filters, $author);

        // Сортировка и пагинация
        $this->applySort($postQuery, $sort);
        $this->applyPagination($postQuery, $filters);

        return $postQuery->get();
    }

    private function applyFilters(Builder $postQuery, array $filters, ?User $author): void
    {
        $this->applyUser($postQuery, $author);
        $this->applyDates($postQuery, $filters);
        // Точка расширения для фильтров
    }

    private function applyUser(Builder $postQuery, ?User $author): void
    {
        $postQuery->when($author !== null, fn (Builder $query) => $query->where(['author_id' => $author->id]));
    }

    private function applyDates(Builder $postQuery, array $filters): void
    {
        $postQuery
            ->when(isset($filters['date_from']), fn (Builder $query) => $query->where('created_at', '>=', Carbon::parse($filters['date_from'])->startOfDay()))
            ->when(isset($filters['date_to']), fn (Builder $query) => $query->where('created_at', '<=', Carbon::parse($filters['date_to'])->endOfDay()));
    }

    private function resolveSort(array $filters): PostSort
    {
        return isset($filters['sort'])
            ? PostSort::from($filters['sort'])
            : self::DEFAULT_SORT;
    }

     private function applySort(Builder $query, PostSort $sort): void
    {
        $mapping = self::SORT_COLUMNS[$sort->value];

        $query->orderBy($mapping['column'], $mapping['direction']);
    }

    private function applyPagination(Builder $postQuery, array $filters): void
    {
        if (isset($filters['limit'])) {
            $postQuery->limit((int) $filters['limit']);
        }
        if (isset($filters['offset'])) {
            $postQuery->offset((int) $filters['offset']);
        }
    }
}