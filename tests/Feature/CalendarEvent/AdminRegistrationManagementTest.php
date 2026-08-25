<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\Admin;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegistrationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected Admin $calendarAdmin;

    protected Admin $bukuTamuAdmin;

    protected User $user;

    protected Event $event;

    protected EventRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = Admin::factory()->superAdmin()->create();
        $this->calendarAdmin = Admin::factory()->calendar()->create();
        $this->bukuTamuAdmin = Admin::factory()->bukuTamu()->create();

        $this->user = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'username' => 'budisantoso',
        ]);

        $this->event = Event::factory()->published()->create([
            'title' => 'Sosialisasi Smart City',
            'category' => 'workshop',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(4),
        ]);

        $this->registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
            'attendance_code' => 'QR12345678',
        ]);
    }

    /**
     * Test guest is redirected to login when accessing calendar dashboard, registrations, or users.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/buku-tamu/admin/calendar/dashboard')
            ->assertRedirect(route('admin.login'));

        $this->get('/buku-tamu/admin/calendar/registrations')
            ->assertRedirect(route('admin.login'));

        $this->get('/buku-tamu/admin/calendar/users')
            ->assertRedirect(route('admin.login'));
    }

    /**
     * Test Buku Tamu admin is forbidden from accessing Calendar Admin routes.
     */
    public function test_buku_tamu_admin_is_forbidden(): void
    {
        $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/dashboard')
            ->assertStatus(403);

        $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations')
            ->assertStatus(403);

        $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/users')
            ->assertStatus(403);
    }

    /**
     * Test Calendar Admin can access calendar dashboard.
     */
    public function test_calendar_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Users');
        $response->assertSee('Total Events');
        $response->assertSee('Total Registrations');
    }

    /**
     * Test Calendar Admin can view registrations list.
     */
    public function test_calendar_admin_can_view_registrations_index(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations');

        $response->assertStatus(200);
        $response->assertSee('Registration Management');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Sosialisasi Smart City');
    }

    /**
     * Test Calendar Admin can filter registrations by status.
     */
    public function test_calendar_admin_can_filter_registrations_by_status(): void
    {
        $attendedReg = EventRegistration::factory()->attended()->create([
            'event_id' => $this->event->id,
        ]);

        $cancelledReg = EventRegistration::factory()->cancelled()->create([
            'event_id' => $this->event->id,
        ]);

        // Filter attended
        $responseAttended = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations?status=attended');

        $responseAttended->assertStatus(200);
        $responseAttended->assertSee($attendedReg->user->name);

        // Filter cancelled
        $responseCancelled = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations?status=cancelled');

        $responseCancelled->assertStatus(200);
        $responseCancelled->assertSee($cancelledReg->user->name);
    }

    /**
     * Test Calendar Admin can search registrations.
     */
    public function test_calendar_admin_can_search_registrations(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations?search=Budi');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
    }

    /**
     * Test Calendar Admin can view registration detail.
     */
    public function test_calendar_admin_can_view_registration_detail(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations/' . $this->registration->id);

        $response->assertStatus(200);
        $response->assertSee('Registration Details');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Sosialisasi Smart City');
    }

    /**
     * Test Calendar Admin can mark registration as attended.
     */
    public function test_calendar_admin_can_mark_attendance(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->post('/buku-tamu/admin/calendar/registrations/' . $this->registration->id . '/attend');

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertEquals('attended', $this->registration->fresh()->status);
        $this->assertNotNull($this->registration->fresh()->attended_at);
    }

    /**
     * Test Calendar Admin can cancel a registration.
     */
    public function test_calendar_admin_can_cancel_registration(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->post('/buku-tamu/admin/calendar/registrations/' . $this->registration->id . '/cancel');

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertEquals('cancelled', $this->registration->fresh()->status);
    }

    /**
     * Test Calendar Admin can view users list.
     */
    public function test_calendar_admin_can_view_users_index(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/users');

        $response->assertStatus(200);
        $response->assertSee('User Management');
        $response->assertSee('Budi Santoso');
    }

    /**
     * Test Calendar Admin can view user detail and event history.
     */
    public function test_calendar_admin_can_view_user_detail(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/users/' . $this->user->id);

        $response->assertStatus(200);
        $response->assertSee('User Details');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Sosialisasi Smart City');
    }

    /**
     * Test Super Admin can also access Calendar Admin modules.
     */
    public function test_super_admin_can_access_calendar_admin_modules(): void
    {
        $this->actingAs($this->superAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/dashboard')
            ->assertStatus(200);

        $this->actingAs($this->superAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/registrations')
            ->assertStatus(200);

        $this->actingAs($this->superAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/users')
            ->assertStatus(200);
    }
}
