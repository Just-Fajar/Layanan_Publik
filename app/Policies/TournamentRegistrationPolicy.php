<?php

namespace App\Policies;

use App\Models\Esport\TournamentRegistration;
use App\Models\User;

class TournamentRegistrationPolicy
{
    /**
     * Determine if the user can view the registration.
     */
    public function view(User $user, TournamentRegistration $registration): bool
    {
        return $user->id === $registration->user_id;
    }

    /**
     * Determine if the user can cancel the registration.
     */
    public function cancel(User $user, TournamentRegistration $registration): bool
    {
        // Can only cancel if it's their own registration and status is 'pending'
        return $user->id === $registration->user_id 
            && $registration->status === 'pending';
    }

    /**
     * Determine if the user can update the registration.
     */
    public function update(User $user, TournamentRegistration $registration): bool
    {
        return $user->id === $registration->user_id 
            && $registration->status === 'pending';
    }
}
