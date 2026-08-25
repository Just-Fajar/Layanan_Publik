<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test seeder creates all standard admin accounts.
     */
    public function test_admin_seeder_creates_standard_admin_roles(): void
    {
        $this->seed(AdminSeeder::class);

        // Super Admin
        $superAdmin = Admin::where('username', 'superadmin')->first();
        $this->assertNotNull($superAdmin);
        $this->assertEquals(Admin::ROLE_SUPER_ADMIN, $superAdmin->role);
        $this->assertEquals('superadmin@kominfo.go.id', $superAdmin->email);
        $this->assertTrue(Hash::check('SuperAdmin123!', $superAdmin->password));

        // Buku Tamu Admin
        $bukuTamuAdmin = Admin::where('username', 'admin_bukutamu')->first();
        $this->assertNotNull($bukuTamuAdmin);
        $this->assertEquals(Admin::ROLE_BUKU_TAMU, $bukuTamuAdmin->role);
        $this->assertTrue(Hash::check('BukuTamu123!', $bukuTamuAdmin->password));

        // Esport Admin
        $esportAdmin = Admin::where('username', 'admin_esport')->first();
        $this->assertNotNull($esportAdmin);
        $this->assertEquals(Admin::ROLE_ESPORT, $esportAdmin->role);
        $this->assertTrue(Hash::check('Esport123!', $esportAdmin->password));

        // Calendar Admin
        $calendarAdmin = Admin::where('username', 'admin_calendar')->first();
        $this->assertNotNull($calendarAdmin);
        $this->assertEquals(Admin::ROLE_CALENDAR, $calendarAdmin->role);
        $this->assertTrue(Hash::check('Calendar123!', $calendarAdmin->password));
    }

    /**
     * Test AdminSeeder is idempotent (can run multiple times without duplicating).
     */
    public function test_admin_seeder_is_idempotent(): void
    {
        $this->seed(AdminSeeder::class);
        $countFirst = Admin::count();

        $this->seed(AdminSeeder::class);
        $countSecond = Admin::count();

        $this->assertEquals($countFirst, $countSecond);
    }
}
