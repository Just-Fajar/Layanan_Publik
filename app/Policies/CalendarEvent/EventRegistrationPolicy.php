<?php

namespace App\Policies\CalendarEvent;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\User;

class EventRegistrationPolicy
{
    /**
     * Determine if the user can view any registrations.
     */
    public function viewAny(?User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine if the user can view the registration.
     */
    public function view(?User $user, EventRegistration $registration): bool
    {
        return $user !== null && $user->id === $registration->user_id;
    }

    /**
     * Determine if the user can create registrations.
     */
    public function create(?User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine if the user can cancel the registration.
     */
    public function cancel(?User $user, EventRegistration $registration): bool
    {
        return $user !== null
            && $user->id === $registration->user_id
            && $registration->isRegistered();
    }

    /**
     * Determine if the user can update the registration.
     */
    public function update(?User $user, EventRegistration $registration): bool
    {
        return $user !== null
            && $user->id === $registration->user_id
            && $registration->isRegistered();
    }
}
