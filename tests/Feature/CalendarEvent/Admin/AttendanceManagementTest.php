<?php

namespace Tests\Feature\CalendarEvent\Admin;

use App\Models\Admin;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected User $user;

    protected Event $event;

    protected EventRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->calendar()->create([
            'username' => 'calendar_admin',
            'password' => bcrypt('password'),
        ]);

        $this->user = User::factory()->create();
        $this->event = Event::factory()->create([
            'title' => 'Test Event',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(7)->addHours(2),
        ]);

        $this->registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
            'attendance_code' => 'ABC123',
        ]);
    }

    /** @test */
    public function admin_can_view_registrations_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.registrations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('calendar.admin.registrations.index');
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function admin_can_filter_registrations_by_status()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.registrations.index', ['status' => 'registered']));

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function admin_can_view_registration_with_qr_code()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.registrations.show', $this->registration));

        $response->assertStatus(200);
        $response->assertViewIs('calendar.admin.registrations.show');
        $response->assertSee($this->user->name);
        $response->assertSee($this->event->title);
        $response->assertSee('ABC123'); // Attendance code
    }

    /** @test */
    public function admin_can_mark_attendance_for_registered_participant()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('calendar.admin.registrations.attend', $this->registration), [
                'notes' => 'Scanned QR code at entrance',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $this->registration->id,
            'status' => 'attended',
        ]);

        $updated = $this->registration->fresh();
        $this->assertEquals('attended', $updated->status);
        $this->assertNotNull($updated->attended_at);
    }

    /** @test */
    public function admin_cannot_mark_attendance_twice()
    {
        $this->registration->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('calendar.admin.registrations.attend', $this->registration), [
                'notes' => 'Second attempt',
            ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_cannot_mark_attendance_for_cancelled_registration()
    {
        $this->registration->update(['status' => 'cancelled']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('calendar.admin.registrations.attend', $this->registration), [
                'notes' => 'Attempt to mark cancelled',
            ]);

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $this->registration->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function attendance_notes_are_optional()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('calendar.admin.registrations.attend', $this->registration), [
                'notes' => '', // Empty notes
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $this->registration->id,
            'status' => 'attended',
        ]);
    }

    /** @test */
    public function admin_dashboard_shows_attendance_rate()
    {
        // Create attended registration
        EventRegistration::factory()->create([
            'event_id' => $this->event->id,
            'status' => 'attended',
        ]);

        // Create cancelled registration
        EventRegistration::factory()->create([
            'event_id' => $this->event->id,
            'status' => 'cancelled',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('statistics');

        $statistics = $response->viewData('statistics');
        $this->assertArrayHasKey('attendance_rate', $statistics);
        $this->assertArrayHasKey('total_registrations', $statistics);
        $this->assertArrayHasKey('registered', $statistics);
        $this->assertArrayHasKey('attended', $statistics);
        $this->assertArrayHasKey('cancelled', $statistics);
    }

    /** @test */
    public function guest_cannot_access_admin_routes()
    {
        $response = $this->get(route('calendar.admin.registrations.index'));

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function esport_admin_cannot_access_calendar_admin_routes()
    {
        $esportAdmin = Admin::factory()->esport()->create([
            'username' => 'esport_admin',
        ]);

        $response = $this->actingAs($esportAdmin, 'admin')
            ->get(route('calendar.admin.registrations.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function qr_code_data_is_displayed_correctly()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('calendar.admin.registrations.show', $this->registration));

        $response->assertStatus(200);
        $response->assertViewHas('registration');

        $viewData = $response->viewData('registration');
        $this->assertEquals('ABC123', $viewData->qr_code);
        $this->assertEquals('ABC123', $viewData->attendance_code);
    }
}
