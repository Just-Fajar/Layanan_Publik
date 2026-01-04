<?php

namespace App\Repositories\Esport;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository
{
    /**
     * Create a new news record.
     */
    public function create(array $data): News
    {
        return News::create($data);
    }

    /**
     * Find news by ID.
     */
    public function find(int $id): ?News
    {
        return News::find($id);
    }

    /**
     * Update news record.
     */
    public function update(News $news, array $data): bool
    {
        return $news->update($data);
    }

    /**
     * Delete news record.
     */
    public function delete(News $news): bool
    {
        return $news->delete();
    }

    /**
     * Get paginated news with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return News::filter($filters)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all news.
     */
    public function getAll(): Collection
    {
        return News::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get news by category.
     */
    public function getByCategory(string $category): Collection
    {
        return News::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get latest news.
     */
    public function getLatest(int $limit = 5): Collection
    {
        return News::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
