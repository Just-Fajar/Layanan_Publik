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

        $this->admin = Admin::factory()->create([
            'username' => 'esport_admin',
            'password' => bcrypt('password'),
            'type' => 'esport',
        ]);
    }

    /** @test */
    public function admin_can_view_login_page()
    {
        $response = $this->get(route('esport.admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.admin.auth.login');
    }

    /** @test */
    public function admin_can_login_with_valid_credentials()
    {
        $response = $this->post(route('esport.admin.login'), [
            'username' => 'esport_admin',
            'password' => 'password',
            'remember' => false,
        ]);

        $response->assertRedirect(route('esport.admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin, 'esport_admin');
    }

    /** @test */
    public function admin_login_fails_with_wrong_password()
    {
        $response = $this->post(route('esport.admin.login'), [
            'username' => 'esport_admin',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('esport_admin');
    }

    /** @test */
    public function calendar_admin_cannot_login_to_esport_admin()
    {
        $calendarAdmin = Admin::factory()->create([
            'username' => 'calendar_admin',
            'password' => bcrypt('password'),
            'type' => 'calendar',
        ]);

        $response = $this->post(route('esport.admin.login'), [
            'username' => 'calendar_admin',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('esport_admin');
    }

    /** @test */
    public function admin_can_logout()
    {
        $this->actingAs($this->admin, 'esport_admin');

        $response = $this->post(route('esport.admin.logout'));

        $response->assertRedirect(route('esport.admin.login'));
        $this->assertGuest('esport_admin');
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('esport.admin.dashboard'));

        $response->assertRedirect(route('esport.admin.login'));
    }

    /** @test */
    public function authenticated_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin, 'esport_admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.admin.dashboard');
    }
}
