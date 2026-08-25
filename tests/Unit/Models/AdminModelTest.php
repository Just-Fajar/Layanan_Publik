<?php

namespace Tests\Unit\Models;

use App\Models\Admin;
use PHPUnit\Framework\TestCase;

class AdminModelTest extends TestCase
{
    /**
     * White-Box Test: Role constants defined and complete.
     */
    public function test_role_constants_are_defined_properly(): void
    {
        $this->assertEquals('super_admin', Admin::ROLE_SUPER_ADMIN);
        $this->assertEquals('admin_buku_tamu', Admin::ROLE_BUKU_TAMU);
        $this->assertEquals('admin_esport', Admin::ROLE_ESPORT);
        $this->assertEquals('admin_calendar', Admin::ROLE_CALENDAR);

        $expectedRoles = [
            Admin::ROLE_SUPER_ADMIN,
            Admin::ROLE_BUKU_TAMU,
            Admin::ROLE_ESPORT,
            Admin::ROLE_CALENDAR,
        ];

        $this->assertEquals($expectedRoles, Admin::ROLES);
    }

    /**
     * White-Box Test: isSuperAdmin helper.
     */
    public function test_is_super_admin_returns_true_only_for_super_admin_role(): void
    {
        $superAdmin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        $bukuTamuAdmin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        $esportAdmin = new Admin(['role' => Admin::ROLE_ESPORT]);
        $calendarAdmin = new Admin(['role' => Admin::ROLE_CALENDAR]);

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertFalse($bukuTamuAdmin->isSuperAdmin());
        $this->assertFalse($esportAdmin->isSuperAdmin());
        $this->assertFalse($calendarAdmin->isSuperAdmin());
    }

    /**
     * White-Box Test: hasRole helper with single string and array.
     */
    public function test_has_role_works_with_single_string_and_array(): void
    {
        $admin = new Admin(['role' => Admin::ROLE_ESPORT]);

        // Single string
        $this->assertTrue($admin->hasRole(Admin::ROLE_ESPORT));
        $this->assertFalse($admin->hasRole(Admin::ROLE_BUKU_TAMU));
        $this->assertFalse($admin->hasRole(Admin::ROLE_SUPER_ADMIN));

        // Array
        $this->assertTrue($admin->hasRole([Admin::ROLE_ESPORT, Admin::ROLE_SUPER_ADMIN]));
        $this->assertTrue($admin->hasRole([Admin::ROLE_ESPORT, Admin::ROLE_BUKU_TAMU]));
        $this->assertFalse($admin->hasRole([Admin::ROLE_BUKU_TAMU, Admin::ROLE_CALENDAR]));
    }

    /**
     * White-Box Test: canAccessModule for Buku Tamu module.
     */
    public function test_can_access_module_for_buku_tamu(): void
    {
        $superAdmin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        $bukuTamuAdmin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        $esportAdmin = new Admin(['role' => Admin::ROLE_ESPORT]);
        $calendarAdmin = new Admin(['role' => Admin::ROLE_CALENDAR]);

        $this->assertTrue($superAdmin->canAccessModule('buku_tamu'));
        $this->assertTrue($bukuTamuAdmin->canAccessModule('buku_tamu'));
        $this->assertFalse($esportAdmin->canAccessModule('buku_tamu'));
        $this->assertFalse($calendarAdmin->canAccessModule('buku_tamu'));
    }

    /**
     * White-Box Test: canAccessModule for Esport module.
     */
    public function test_can_access_module_for_esport(): void
    {
        $superAdmin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        $bukuTamuAdmin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        $esportAdmin = new Admin(['role' => Admin::ROLE_ESPORT]);
        $calendarAdmin = new Admin(['role' => Admin::ROLE_CALENDAR]);

        $this->assertTrue($superAdmin->canAccessModule('esport'));
        $this->assertFalse($bukuTamuAdmin->canAccessModule('esport'));
        $this->assertTrue($esportAdmin->canAccessModule('esport'));
        $this->assertFalse($calendarAdmin->canAccessModule('esport'));
    }

    /**
     * White-Box Test: canAccessModule for Calendar module.
     */
    public function test_can_access_module_for_calendar(): void
    {
        $superAdmin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        $bukuTamuAdmin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        $esportAdmin = new Admin(['role' => Admin::ROLE_ESPORT]);
        $calendarAdmin = new Admin(['role' => Admin::ROLE_CALENDAR]);

        $this->assertTrue($superAdmin->canAccessModule('calendar'));
        $this->assertFalse($bukuTamuAdmin->canAccessModule('calendar'));
        $this->assertFalse($esportAdmin->canAccessModule('calendar'));
        $this->assertTrue($calendarAdmin->canAccessModule('calendar'));
    }

    /**
     * White-Box Test: canAccessModule for Super Admin only modules (admins, settings).
     */
    public function test_can_access_module_for_super_admin_only_areas(): void
    {
        $superAdmin = new Admin(['role' => Admin::ROLE_SUPER_ADMIN]);
        $bukuTamuAdmin = new Admin(['role' => Admin::ROLE_BUKU_TAMU]);
        $esportAdmin = new Admin(['role' => Admin::ROLE_ESPORT]);
        $calendarAdmin = new Admin(['role' => Admin::ROLE_CALENDAR]);

        $this->assertTrue($superAdmin->canAccessModule('admins'));
        $this->assertTrue($superAdmin->canAccessModule('settings'));

        $this->assertFalse($bukuTamuAdmin->canAccessModule('admins'));
        $this->assertFalse($esportAdmin->canAccessModule('admins'));
        $this->assertFalse($calendarAdmin->canAccessModule('admins'));

        $this->assertFalse($bukuTamuAdmin->canAccessModule('settings'));
        $this->assertFalse($esportAdmin->canAccessModule('settings'));
        $this->assertFalse($calendarAdmin->canAccessModule('settings'));
    }
}
