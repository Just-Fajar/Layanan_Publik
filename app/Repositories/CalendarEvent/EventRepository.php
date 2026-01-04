<?php

namespace App\Repositories\CalendarEvent;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class EventRepository
{
    /**
     * Create a new event record.
     */
    public function create(array $data): Event
    {
        return Event::create($data);
    }

    /**
     * Find event by ID.
     */
    public function find(int $id): ?Event
    {
        return Event::find($id);
    }

    /**
     * Update event record.
     */
    public function update(Event $event, array $data): bool
    {
        return $event->update($data);
    }

    /**
     * Delete event record (soft delete).
     */
    public function delete(Event $event): bool
    {
        return $event->delete();
    }

    /**
     * Force delete event record.
     */
    public function forceDelete(Event $event): bool
    {
        return $event->forceDelete();
    }

    /**
     * Get paginated events with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Event::filter($filters)
            ->orderBy('start_date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all events.
     */
    public function getAll(): Collection
    {
        return Event::orderBy('start_date', 'desc')->get();
    }

    /**
     * Get published events.
     */
    public function getPublished(?int $perPage = null): Collection|LengthAwarePaginator
    {
        $query = Event::published()->orderBy('start_date', 'desc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get upcoming events.
     */
    public function getUpcoming(?int $limit = null): Collection
    {
        $query = Event::upcoming()->orderBy('start_date', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get events by category.
     */
    public function getByCategory(string $category): Collection
    {
        return Event::where('category', $category)
            ->published()
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Get events by status.
     */
    public function getByStatus(string $status): Collection
    {
        return Event::where('status', $status)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Get events by date range.
     */
    public function getByDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return Event::whereBetween('start_date', [$startDate, $endDate])
            ->published()
            ->orderBy('start_date', 'asc')
            ->get();
    }

    /**
     * Bulk update events status.
     */
    public function bulkUpdateStatus(array $eventIds, string $status): int
    {
        return Event::whereIn('id', $eventIds)->update(['status' => $status]);
    }
}
