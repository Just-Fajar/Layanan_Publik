<?php

namespace Tests\Feature\Esport;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get(route('esport.auth.login'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.auth.login');
    }

    /** @test */
    public function user_can_login_with_username()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('esport.auth.login'), [
            'username' => 'testuser',
            'password' => 'password123',
            'remember' => false,
        ]);

        $response->assertRedirect(route('esport.user.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('esport.auth.login'), [
            'username' => 'test@test.com', // Using email in username field
            'password' => 'password123',
            'remember' => false,
        ]);

        $response->assertRedirect(route('esport.user.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_use_remember_me_feature()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('esport.auth.login'), [
            'username' => 'testuser',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertRedirect(route('esport.user.dashboard'));
        $this->assertAuthenticatedAs($user);
        $response->assertCookie('remember_web_' . sha1(User::class));
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('esport.auth.login'), [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function login_fails_with_non_existent_user()
    {
        $response = $this->post(route('esport.auth.login'), [
            'username' => 'nonexistent',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('esport.auth.logout'));

        $response->assertRedirect(route('esport.home'));
        $this->assertGuest();
    }

    /** @test */
    public function guest_cannot_access_protected_routes()
    {
        $response = $this->get(route('esport.user.dashboard'));

        $response->assertRedirect(route('esport.auth.login'));
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('esport.user.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.user.dashboard');
    }
}
