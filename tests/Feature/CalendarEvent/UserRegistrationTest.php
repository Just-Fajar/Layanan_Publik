<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_registration_page()
    {
        $response = $this->get(route('calendar.auth.register'));

        $response->assertStatus(200);
        $response->assertViewIs('calendar.auth.register');
    }

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $userData = [
            'name' => 'Test Calendar User',
            'username' => 'calendar_test1',
            'email' => 'calendar_test1@test.com',
            'phone' => '081987654321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('calendar.auth.register'), $userData);

        $response->assertRedirect(route('calendar.user.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => 'calendar_test1',
            'email' => 'calendar_test1@test.com',
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function registration_fails_with_duplicate_username()
    {
        User::factory()->create(['username' => 'testuser']);

        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'unique@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('calendar.auth.register'), $userData);

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
            'email' => 'existing@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('calendar.auth.register'), $userData);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function registration_validates_phone_format()
    {
        $userData = [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@test.com',
            'phone' => 'invalid', // Invalid phone
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('calendar.auth.register'), $userData);

        $response->assertSessionHasErrors('phone');
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

        $this->post(route('calendar.auth.register'), $userData);

        $this->assertAuthenticated();
        $this->assertEquals('testuser', auth()->user()->username);
    }
}
