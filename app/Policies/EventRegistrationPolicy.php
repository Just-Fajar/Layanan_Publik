<?php

namespace App\Policies;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\User;

class EventRegistrationPolicy
{
    /**
     * Determine if the user can view the registration.
     */
    public function view(?User $user, EventRegistration $registration): bool
    {
        return $user !== null && $user->id === $registration->user_id;
    }

    /**
     * Determine if the user can cancel the registration.
     */
    public function cancel(?User $user, EventRegistration $registration): bool
    {
        return $user !== null
            && $user->id === $registration->user_id
            && $registration->status === 'registered';
    }

    /**
     * Determine if the user can update the registration.
     */
    public function update(?User $user, EventRegistration $registration): bool
    {
        return $user !== null
            && $user->id === $registration->user_id
            && $registration->status === 'registered';
    }
}
