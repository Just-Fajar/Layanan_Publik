<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected Admin $bukuTamuAdmin;

    protected Admin $esportAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = Admin::factory()->superAdmin()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@kominfo.go.id',
            'password' => bcrypt('password123'),
        ]);

        $this->bukuTamuAdmin = Admin::factory()->bukuTamu()->create([
            'username' => 'admin_bukutamu',
            'email' => 'admin_bukutamu@kominfo.go.id',
            'password' => bcrypt('password123'),
        ]);

        $this->esportAdmin = Admin::factory()->esport()->create([
            'username' => 'admin_esport',
            'email' => 'admin_esport@kominfo.go.id',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * Test admin can view login page.
     */
    public function test_admin_can_view_login_page(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('buku_tamu.admin.login');
    }

    /**
     * Test authenticated admin is redirected when visiting login page.
     */
    public function test_authenticated_admin_is_redirected_away_from_login(): void
    {
        $response = $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get(route('admin.login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * Test admin can login with valid username.
     */
    public function test_admin_can_login_with_valid_username(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'login' => 'superadmin',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->superAdmin, 'admin');
    }

    /**
     * Test admin can login with valid email.
     */
    public function test_admin_can_login_with_valid_email(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'login' => 'admin_bukutamu@kominfo.go.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->bukuTamuAdmin, 'admin');
    }

    /**
     * Test esport admin login redirects to esport admin dashboard.
     */
    public function test_esport_admin_login_redirects_to_esport_dashboard(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'username' => 'admin_esport',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('esport.admin.dashboard'));
        $this->assertAuthenticatedAs($this->esportAdmin, 'admin');
    }

    /**
     * Test admin cannot login with incorrect password.
     */
    public function test_admin_cannot_login_with_incorrect_password(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'login' => 'superadmin',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('login');
        $this->assertGuest('admin');
    }

    /**
     * Test AJAX login returns JSON response on success.
     */
    public function test_ajax_login_returns_json_on_success(): void
    {
        $response = $this->postJson(route('admin.login.submit'), [
            'username' => 'superadmin',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Login berhasil!',
            'data' => [
                'redirect' => route('admin.dashboard'),
            ],
        ]);
        $this->assertAuthenticatedAs($this->superAdmin, 'admin');
    }

    /**
     * Test AJAX login returns JSON 401 on failure.
     */
    public function test_ajax_login_returns_401_on_failure(): void
    {
        $response = $this->postJson(route('admin.login.submit'), [
            'username' => 'superadmin',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Username/email atau password salah.',
        ]);
        $this->assertGuest('admin');
    }

    /**
     * Test admin logout destroys session and redirects to login.
     */
    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->superAdmin, 'admin')
            ->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }
}
