<?php

namespace App\Services\BukuTamu;

use App\Models\Visitor;
use App\Repositories\BukuTamu\VisitorRepository;
use Carbon\Carbon;

class VisitorService
{
    public function __construct(
        private GeolocationService $geolocationService,
        private ImageService $imageService,
        private VisitorRepository $repository
    ) {}

    /**
     * Create a new visitor record.
     *
     * @throws \Exception
     */
    public function createVisitor(array $data): Visitor
    {
        // Validate location
        $this->geolocationService->validateLocation(
            $data['latitude'] ?? null,
            $data['longitude'] ?? null
        );

        // Process and store photo
        if (isset($data['photo'])) {
            $data['photo_path'] = $this->imageService->storeBase64Image($data['photo']);
            unset($data['photo']);
        }

        // Set visit date
        $data['visit_date'] = Carbon::now();

        // Create visitor record via repository
        return $this->repository->create($data);
    }

    /**
     * Get visitors with filters.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getVisitors(array $filters = [], ?int $perPage = null)
    {
        $perPage = $perPage ?? config('pagination.api.default');

        return $this->repository->getPaginated($filters, $perPage);
    }

    /**
     * Update visitor record.
     */
    public function updateVisitor(Visitor $visitor, array $data): Visitor
    {
        // Handle photo update if provided
        if (isset($data['photo'])) {
            // Delete old photo
            $this->imageService->deleteImage($visitor->photo_path);

            // Store new photo
            $data['photo_path'] = $this->imageService->storeBase64Image($data['photo']);
            unset($data['photo']);
        }

        $this->repository->update($visitor, $data);

        return $visitor->fresh();
    }

    /**
     * Delete visitor record.
     */
    public function deleteVisitor(Visitor $visitor): bool
    {
        // Delete photo file
        $this->imageService->deleteImage($visitor->photo_path);

        // Delete record via repository
        return $this->repository->delete($visitor);
    }

    /**
     * Get visitor statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->repository->getTotalCount(),
            'today' => $this->repository->getTodayCount(),
            'this_week' => $this->repository->getWeekCount(),
            'this_month' => Visitor::whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->count(),
        ];
    }
}
