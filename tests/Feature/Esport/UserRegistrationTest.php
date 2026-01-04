<?php

namespace Tests\Feature\Esport;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_registration_page()
    {
        $response = $this->get(route('esport.auth.register'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.auth.register');
    }

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $userData = [
            'name' => 'Test E-sport User',
            'username' => 'esport_test1',
            'email' => 'esport_test1@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertRedirect(route('esport.user.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => 'esport_test1',
            'email' => 'esport_test1@test.com',
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function registration_fails_with_duplicate_username()
    {
        User::factory()->create(['username' => 'testuser']);

        $userData = [
            'name' => 'Test User',
            'username' => 'testuser', // Duplicate
            'email' => 'unique@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'existing@test.com']);

        $userData = [
            'name' => 'Test User',
            'username' => 'uniqueuser',
            'email' => 'existing@test.com', // Duplicate
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_invalid_email_format()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'invalid-email', // Invalid format
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_short_password()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@test.com',
            'phone' => '081234567890',
            'password' => 'short', // Less than 8 characters
            'password_confirmation' => 'short',
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_password_mismatch()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'different123', // Mismatch
        ];

        $response = $this->post(route('esport.auth.register'), $userData);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /** @test */
    public function registration_fails_with_missing_required_fields()
    {
        $response = $this->post(route('esport.auth.register'), []);

        $response->assertSessionHasErrors(['name', 'username', 'email', 'phone', 'password']);
        $this->assertGuest();
    }

    /** @test */
    public function registered_user_is_automatically_logged_in()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->post(route('esport.auth.register'), $userData);

        $this->assertAuthenticated();
        $this->assertEquals('testuser', auth()->user()->username);
    }
}
