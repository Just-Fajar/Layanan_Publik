<?php

namespace App\Policies\Esport;

use App\Models\Admin;
use App\Models\Tournament;

class TournamentPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        // All admins can view tournaments list
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Tournament $tournament): bool
    {
        // All admins can view tournament details
        return true;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        // All authenticated admins can create tournaments
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Tournament $tournament): bool
    {
        // All admins can update tournaments
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $tournament->created_by === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Tournament $tournament): bool
    {
        // All admins can delete tournaments
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $tournament->created_by === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Tournament $tournament): bool
    {
        // All admins can restore soft-deleted tournaments
        return true;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Tournament $tournament): bool
    {
        // Only super admins can permanently delete
        // TODO: Implement role check when role system is added
        // return $admin->hasRole('super-admin');
        return true;
    }
}
