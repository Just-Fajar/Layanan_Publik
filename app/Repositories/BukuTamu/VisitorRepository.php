<?php

namespace App\Repositories\BukuTamu;

use App\Models\Visitor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class VisitorRepository
{
    /**
     * Create a new visitor record.
     */
    public function create(array $data): Visitor
    {
        return Visitor::create($data);
    }

    /**
     * Find visitor by ID.
     */
    public function find(int $id): ?Visitor
    {
        return Visitor::find($id);
    }

    /**
     * Update visitor record.
     */
    public function update(Visitor $visitor, array $data): bool
    {
        return $visitor->update($data);
    }

    /**
     * Delete visitor record.
     */
    public function delete(Visitor $visitor): bool
    {
        return $visitor->delete();
    }

    /**
     * Get paginated visitors with optional filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Visitor::query();

        if (! empty($filters['purpose'])) {
            $query->where('purpose', $filters['purpose']);
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('visit_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('visit_date', '<=', $filters['date_to']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%")
                    ->orWhere('Institution', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('visit_date', 'desc')->paginate($perPage);
    }

    /**
     * Get visitors by date range.
     */
    public function getByDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return Visitor::whereBetween('visit_date', [$startDate, $endDate])
            ->orderBy('visit_date', 'desc')
            ->get();
    }

    /**
     * Get total visitor count.
     */
    public function getTotalCount(): int
    {
        return Visitor::count();
    }

    /**
     * Get visitors count for today.
     */
    public function getTodayCount(): int
    {
        return Visitor::whereDate('visit_date', today())->count();
    }

    /**
     * Get visitors count for current week.
     */
    public function getWeekCount(): int
    {
        return Visitor::whereBetween('visit_date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();
    }

    /**
     * Get visitors count by purpose.
     */
    public function getCountByPurpose(): Collection
    {
        return Visitor::selectRaw('purpose, COUNT(*) as count')
            ->groupBy('purpose')
            ->orderBy('count', 'desc')
            ->get();
    }
}
