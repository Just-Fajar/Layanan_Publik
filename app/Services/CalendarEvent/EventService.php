<?php

namespace App\Services\CalendarEvent;

use App\Models\Event;
use App\Repositories\CalendarEvent\EventRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventService
{
    public function __construct(
        private EventRepository $repository
    ) {}

    /**
     * Create a new event.
     */
    public function createEvent(array $data): Event
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->storeImage($data['image']);
        }

        // Set defaults if not provided
        $data['status'] = $data['status'] ?? config('calendar_event.statuses.draft', 'draft');
        $data['is_public'] = $data['is_public'] ?? config('calendar_event.defaults.is_public', true);

        return $this->repository->create($data);
    }

    /**
     * Update event.
     */
    public function updateEvent(Event $event, array $data): bool
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($event->image) {
                $this->deleteImage($event->image);
            }

            $data['image'] = $this->storeImage($data['image']);
        }

        return $this->repository->update($event, $data);
    }

    /**
     * Delete event.
     */
    public function deleteEvent(Event $event): bool
    {
        // Delete image if exists
        if ($event->image) {
            $this->deleteImage($event->image);
        }

        return $this->repository->delete($event);
    }

    /**
     * Get paginated events with filters.
     */
    public function getEvents(array $filters = [], ?int $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? config('pagination.web.events', 12);

        return $this->repository->getPaginated($filters, $perPage);
    }

    /**
     * Get published events.
     */
    public function getPublishedEvents(?int $perPage = null): Collection|LengthAwarePaginator
    {
        return $this->repository->getPublished($perPage);
    }

    /**
     * Get upcoming events.
     */
    public function getUpcomingEvents(int $limit = 5): Collection
    {
        return $this->repository->getUpcoming($limit);
    }

    /**
     * Get events by category.
     */
    public function getEventsByCategory(string $category): Collection
    {
        return $this->repository->getByCategory($category);
    }

    /**
     * Get events by status.
     */
    public function getEventsByStatus(string $status): Collection
    {
        return $this->repository->getByStatus($status);
    }

    /**
     * Get events for calendar view (by date range).
     */
    public function getEventsForCalendar(Carbon $startDate, Carbon $endDate): Collection
    {
        return $this->repository->getByDateRange($startDate, $endDate);
    }

    /**
     * Bulk update event status.
     */
    public function bulkUpdateStatus(array $eventIds, string $status): int
    {
        return $this->repository->bulkUpdateStatus($eventIds, $status);
    }

    /**
     * Store event image.
     */
    private function storeImage(UploadedFile $image): string
    {
        $storagePath = config('calendar_event.upload.storage_path', 'events');

        return $image->store($storagePath, 'public');
    }

    /**
     * Delete event image.
     */
    private function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
