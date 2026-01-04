<?php

namespace App\Policies\Esport;

use App\Models\Admin;
use App\Models\News;

class NewsPolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        // All admins can view news list
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, News $news): bool
    {
        // All admins can view news details
        return true;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        // All authenticated admins can create news
        return true;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, News $news): bool
    {
        // All admins can update news
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $news->author_id === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, News $news): bool
    {
        // All admins can delete news
        // TODO: Add role-based check if needed
        // return $admin->hasRole('super-admin') || $news->author_id === $admin->id;
        return true;
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, News $news): bool
    {
        // All admins can restore soft-deleted news
        return true;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, News $news): bool
    {
        // Only super admins can permanently delete
        // TODO: Implement role check when role system is added
        // return $admin->hasRole('super-admin');
        return true;
    }
}
