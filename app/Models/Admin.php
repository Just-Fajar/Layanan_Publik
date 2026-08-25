<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Role Constants
     */
    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_BUKU_TAMU = 'admin_buku_tamu';

    public const ROLE_ESPORT = 'admin_esport';

    public const ROLE_CALENDAR = 'admin_calendar';

    /**
     * List of all valid roles
     */
    public const ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_BUKU_TAMU,
        self::ROLE_ESPORT,
        self::ROLE_CALENDAR,
    ];

    /**
     * Module to Role mappings for RBAC
     */
    public const MODULE_ROLES = [
        'buku_tamu' => [self::ROLE_SUPER_ADMIN, self::ROLE_BUKU_TAMU],
        'esport' => [self::ROLE_SUPER_ADMIN, self::ROLE_ESPORT],
        'calendar' => [self::ROLE_SUPER_ADMIN, self::ROLE_CALENDAR],
        'settings' => [self::ROLE_SUPER_ADMIN],
        'admins' => [self::ROLE_SUPER_ADMIN],
    ];

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if admin is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if admin has specific role(s)
     *
     * @param  string|array<string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }

        return $this->role === $roles;
    }

    /**
     * Check if admin can access a given module
     */
    public function canAccessModule(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $allowedRoles = self::MODULE_ROLES[$module] ?? [];

        return in_array($this->role, $allowedRoles, true);
    }
}
