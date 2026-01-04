<?php

namespace App\Policies\CalendarEvent;

use App\Models\Admin;
use App\Models\Event;

class EventPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        // All admins can view events list
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Event $event): bool
    {
        // All admins can view event details
        return true;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        // All authenticated admins can create events
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Event $event): bool
    {
        // All admins can update events
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $event->created_by === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Event $event): bool
    {
        // All admins can delete events
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $event->created_by === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Event $event): bool
    {
        // All admins can restore soft-deleted events
        return true;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Event $event): bool
    {
        // Only super admins can permanently delete
        // TODO: Implement role check when role system is added
        // return $admin->hasRole('super-admin');
        return true;
    }
}
