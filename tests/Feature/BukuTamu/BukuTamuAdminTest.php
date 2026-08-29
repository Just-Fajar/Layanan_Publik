<?php

namespace Tests\Feature\BukuTamu;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuTamuAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200)
            ->assertViewIs('buku_tamu.admin.login');
    }

    public function test_admin_with_buku_tamu_role_can_login_with_username(): void
    {
        $admin = Admin::factory()->bukuTamu()->create([
            'username' => 'admin_bukutamu',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'login' => 'admin_bukutamu',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_with_buku_tamu_role_can_login_with_email(): void
    {
        $admin = Admin::factory()->bukuTamu()->create([
            'email' => 'bukutamu@madiunkab.go.id',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'login' => 'bukutamu@madiunkab.go.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_login_fails_with_invalid_password(): void
    {
        Admin::factory()->bukuTamu()->create([
            'username' => 'admin_bukutamu',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'login' => 'admin_bukutamu',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors(['login']);
        $this->assertGuest('admin');
    }

    public function test_buku_tamu_admin_can_access_dashboard_and_calendar(): void
    {
        $admin = Admin::factory()->bukuTamu()->create();

        $responseDashboard = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));
        $responseDashboard->assertStatus(200)
            ->assertViewIs('buku_tamu.admin.dashboard');

        $responseVisitors = $this->actingAs($admin, 'admin')->get(route('admin.visitors'));
        $responseVisitors->assertStatus(200)
            ->assertViewIs('buku_tamu.admin.visitors');

        $responseCalendar = $this->actingAs($admin, 'admin')->get(route('admin.calendar'));
        $responseCalendar->assertStatus(200)
            ->assertViewIs('buku_tamu.admin.calendar');
    }

    public function test_super_admin_can_access_buku_tamu_dashboard(): void
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin, 'admin')->get(route('admin.dashboard'));
        $response->assertStatus(200);

        $responseVisitors = $this->actingAs($superAdmin, 'admin')->get(route('admin.visitors'));
        $responseVisitors->assertStatus(200);
    }

    public function test_admin_from_other_module_cannot_access_buku_tamu_dashboard(): void
    {
        $esportAdmin = Admin::factory()->esport()->create();

        $response = $this->actingAs($esportAdmin, 'admin')->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_buku_tamu_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_buku_tamu_admin_can_logout(): void
    {
        $admin = Admin::factory()->bukuTamu()->create();

        $response = $this->actingAs($admin, 'admin')->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    public function test_api_admin_auth_login_logout_and_profile(): void
    {
        $admin = Admin::factory()->bukuTamu()->create([
            'username' => 'api_admin',
            'password' => bcrypt('password123'),
        ]);

        // 1. API Login
        $loginResponse = $this->postJson('/api/auth/login', [
            'username' => 'api_admin',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful',
            ]);

        $token = $loginResponse->json('data.token');
        $this->assertNotEmpty($token);

        // 2. API Profile with bearer token
        $profileResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/profile');

        $profileResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $admin->id,
                    'username' => 'api_admin',
                ],
            ]);

        // 3. API Logout
        $logoutResponse = $this->postJson('/api/auth/logout');
        $logoutResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful',
            ]);
    }
}
