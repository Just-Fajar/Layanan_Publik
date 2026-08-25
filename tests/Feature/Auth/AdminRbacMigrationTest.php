<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminRbacMigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Grey-Box Test: Ensure role column exists on admins table.
     */
    public function test_admins_table_has_role_column(): void
    {
        $this->assertTrue(Schema::hasColumn('admins', 'role'));
    }

    /**
     * Grey-Box Test: Creating default admin via factory sets role to admin_buku_tamu.
     */
    public function test_default_admin_factory_creates_buku_tamu_role(): void
    {
        $admin = Admin::factory()->create([
            'username' => 'test_buku_tamu',
            'email' => 'bukutamu@example.com',
        ]);

        $this->assertEquals(Admin::ROLE_BUKU_TAMU, $admin->role);
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'username' => 'test_buku_tamu',
            'role' => Admin::ROLE_BUKU_TAMU,
        ]);
    }

    /**
     * Grey-Box Test: Factory superAdmin state assigns super_admin role.
     */
    public function test_super_admin_factory_state(): void
    {
        $admin = Admin::factory()->superAdmin()->create([
            'username' => 'superadmin',
            'email' => 'super@example.com',
        ]);

        $this->assertTrue($admin->isSuperAdmin());
        $this->assertEquals(Admin::ROLE_SUPER_ADMIN, $admin->role);
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'role' => Admin::ROLE_SUPER_ADMIN,
        ]);
    }

    /**
     * Grey-Box Test: Factory esport state assigns admin_esport role.
     */
    public function test_esport_admin_factory_state(): void
    {
        $admin = Admin::factory()->esport()->create([
            'username' => 'esport_admin',
            'email' => 'esport@example.com',
        ]);

        $this->assertEquals(Admin::ROLE_ESPORT, $admin->role);
        $this->assertTrue($admin->canAccessModule('esport'));
        $this->assertFalse($admin->canAccessModule('buku_tamu'));
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'role' => Admin::ROLE_ESPORT,
        ]);
    }

    /**
     * Grey-Box Test: Factory calendar state assigns admin_calendar role.
     */
    public function test_calendar_admin_factory_state(): void
    {
        $admin = Admin::factory()->calendar()->create([
            'username' => 'calendar_admin',
            'email' => 'calendar@example.com',
        ]);

        $this->assertEquals(Admin::ROLE_CALENDAR, $admin->role);
        $this->assertTrue($admin->canAccessModule('calendar'));
        $this->assertFalse($admin->canAccessModule('esport'));
        $this->assertDatabaseHas('admins', [
            'id' => $admin->id,
            'role' => Admin::ROLE_CALENDAR,
        ]);
    }
}
