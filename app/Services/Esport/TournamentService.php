<?php

namespace App\Services\Esport;

use App\Models\Tournament;
use App\Repositories\Esport\TournamentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TournamentService
{
    public function __construct(
        private TournamentRepository $repository
    ) {}

    /**
     * Create a new tournament.
     */
    public function createTournament(array $data): Tournament
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->storeImage($data['image']);
        }

        return $this->repository->create($data);
    }

    /**
     * Update tournament.
     */
    public function updateTournament(Tournament $tournament, array $data): bool
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($tournament->image) {
                $this->deleteImage($tournament->image);
            }

            $data['image'] = $this->storeImage($data['image']);
        }

        return $this->repository->update($tournament, $data);
    }

    /**
     * Delete tournament.
     */
    public function deleteTournament(Tournament $tournament): bool
    {
        // Delete image if exists
        if ($tournament->image) {
            $this->deleteImage($tournament->image);
        }

        return $this->repository->delete($tournament);
    }

    /**
     * Get paginated tournaments with filters.
     */
    public function getTournaments(array $filters = [], ?int $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? config('pagination.web.tournaments', 9);

        return $this->repository->getPaginated($filters, $perPage);
    }

    /**
     * Get upcoming tournaments.
     */
    public function getUpcomingTournaments(int $limit = 5): Collection
    {
        return $this->repository->getUpcoming($limit);
    }

    /**
     * Get tournaments by game.
     */
    public function getTournamentsByGame(string $game): Collection
    {
        return $this->repository->getByGame($game);
    }

    /**
     * Store tournament image.
     */
    private function storeImage(UploadedFile $image): string
    {
        $storagePath = config('esport.upload.tournament_image.storage_path', 'tournaments');

        return $image->store($storagePath, 'public');
    }

    /**
     * Delete tournament image.
     */
    private function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
