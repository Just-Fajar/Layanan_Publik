<?php

namespace App\Services\Esport;

use App\Models\News;
use App\Repositories\Esport\NewsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    public function __construct(
        private NewsRepository $repository
    ) {}

    /**
     * Create a new news article.
     */
    public function createNews(array $data): News
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->storeImage($data['image']);
        }

        return $this->repository->create($data);
    }

    /**
     * Update news article.
     */
    public function updateNews(News $news, array $data): bool
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($news->image) {
                $this->deleteImage($news->image);
            }

            $data['image'] = $this->storeImage($data['image']);
        }

        return $this->repository->update($news, $data);
    }

    /**
     * Delete news article.
     */
    public function deleteNews(News $news): bool
    {
        // Delete image if exists
        if ($news->image) {
            $this->deleteImage($news->image);
        }

        return $this->repository->delete($news);
    }

    /**
     * Get paginated news with filters.
     */
    public function getNews(array $filters = [], ?int $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? config('pagination.web.news', 9);

        return $this->repository->getPaginated($filters, $perPage);
    }

    /**
     * Get latest news.
     */
    public function getLatestNews(int $limit = 5): Collection
    {
        return $this->repository->getLatest($limit);
    }

    /**
     * Get news by category.
     */
    public function getNewsByCategory(string $category): Collection
    {
        return $this->repository->getByCategory($category);
    }

    /**
     * Store news image.
     */
    private function storeImage(UploadedFile $image): string
    {
        $storagePath = config('esport.upload.news_image.storage_path', 'news');

        return $image->store($storagePath, 'public');
    }

    /**
     * Delete news image.
     */
    private function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
