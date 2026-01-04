<?php

namespace App\Policies\Esport;

use App\Models\Esport\TournamentRegistration;
use App\Models\User;

class TournamentRegistrationPolicy
{
    /**
     * Determine if the user can view any registrations.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the registration.
     */
    public function view(User $user, TournamentRegistration $registration): bool
    {
        return $user->id === $registration->user_id;
    }

    /**
     * Determine if the user can create registrations.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can cancel the registration.
     */
    public function cancel(User $user, TournamentRegistration $registration): bool
    {
        return $user->id === $registration->user_id && $registration->isPending();
    }

    /**
     * Determine if the user can update the registration.
     */
    public function update(User $user, TournamentRegistration $registration): bool
    {
        return $user->id === $registration->user_id && $registration->isPending();
    }
}
