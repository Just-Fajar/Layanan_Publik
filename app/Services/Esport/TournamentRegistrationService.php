<?php

namespace App\Services\Esport;

use App\Models\Esport\Tournament;
use App\Models\Esport\TournamentRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TournamentRegistrationService
{
    /**
     * Register user for tournament.
     */
    public function register(User $user, Tournament $tournament, array $data): TournamentRegistration
    {
        return DB::transaction(function () use ($user, $tournament, $data) {
            $registration = TournamentRegistration::create([
                'user_id' => $user->id,
                'tournament_id' => $tournament->id,
                'team_name' => $data['team_name'] ?? null,
                'team_members' => $data['team_members'] ?? null,
                'in_game_id' => $data['in_game_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
            ]);

            // TODO: Send notification to user
            // TODO: Send notification to admin

            return $registration;
        });
    }

    /**
     * Cancel registration.
     */
    public function cancel(TournamentRegistration $registration): bool
    {
        if (! $registration->isPending()) {
            throw new \Exception('Hanya registrasi dengan status pending yang bisa dibatalkan.');
        }

        return $registration->delete();
    }

    /**
     * Approve registration.
     */
    public function approve(TournamentRegistration $registration, ?int $adminId = null): bool
    {
        $data = [
            'status' => 'approved',
            'rejection_reason' => null,
        ];
        
        if ($adminId) {
            $data['approved_by'] = $adminId;
        }
        
        $registration->update($data);

        // TODO: Send approval notification to user

        return true;
    }

    /**
     * Reject registration.
     */
    public function reject(TournamentRegistration $registration, string $reason, ?int $adminId = null): bool
    {
        $data = [
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ];
        
        if ($adminId) {
            $data['rejected_by'] = $adminId;
        }
        
        $registration->update($data);

        // TODO: Send rejection notification to user

        return true;
    }

    /**
     * Get user registrations.
     */
    public function getUserRegistrations(User $user)
    {
        return TournamentRegistration::with('tournament')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
    }

    /**
     * Check if user already registered for tournament.
     */
    public function isAlreadyRegistered(User $user, Tournament $tournament): bool
    {
        return TournamentRegistration::where('user_id', $user->id)
            ->where('tournament_id', $tournament->id)
            ->exists();
    }
}
