<?php

namespace Tests\Feature\Esport\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->esport()->create([
            'username' => 'esport_admin',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function admin_can_view_login_page()
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('buku_tamu.admin.login');
    }

    /** @test */
    public function admin_can_login_with_valid_credentials()
    {
        $response = $this->post(route('admin.login.submit'), [
            'username' => 'esport_admin',
            'password' => 'password',
            'remember' => false,
        ]);

        $response->assertRedirect(route('esport.admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    /** @test */
    public function admin_login_fails_with_wrong_password()
    {
        $response = $this->post(route('admin.login.submit'), [
            'username' => 'esport_admin',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('admin');
    }

    /** @test */
    public function calendar_admin_cannot_access_esport_admin_dashboard()
    {
        $calendarAdmin = Admin::factory()->calendar()->create([
            'username' => 'calendar_admin',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($calendarAdmin, 'admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_logout()
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('esport.admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function authenticated_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.admin.dashboard');
    }
}
