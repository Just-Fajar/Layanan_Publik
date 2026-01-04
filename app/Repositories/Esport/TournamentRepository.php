<?php

namespace App\Repositories\Esport;

use App\Models\Tournament;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TournamentRepository
{
    /**
     * Create a new tournament record.
     */
    public function create(array $data): Tournament
    {
        return Tournament::create($data);
    }

    /**
     * Find tournament by ID.
     */
    public function find(int $id): ?Tournament
    {
        return Tournament::find($id);
    }

    /**
     * Update tournament record.
     */
    public function update(Tournament $tournament, array $data): bool
    {
        return $tournament->update($data);
    }

    /**
     * Delete tournament record.
     */
    public function delete(Tournament $tournament): bool
    {
        return $tournament->delete();
    }

    /**
     * Get paginated tournaments with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Tournament::filter($filters)
            ->orderBy('date', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all tournaments.
     */
    public function getAll(): Collection
    {
        return Tournament::orderBy('date', 'desc')->get();
    }

    /**
     * Get tournaments by status.
     */
    public function getByStatus(string $status): Collection
    {
        return Tournament::where('status', $status)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get tournaments by game.
     */
    public function getByGame(string $game): Collection
    {
        return Tournament::where('game', $game)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get upcoming tournaments.
     */
    public function getUpcoming(?int $limit = null): Collection
    {
        $query = Tournament::where('date', '>=', now())
            ->where('status', 'upcoming')
            ->orderBy('date', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
