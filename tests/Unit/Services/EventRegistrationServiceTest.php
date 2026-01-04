<?php

namespace Tests\Unit\Services;

use App\Models\Event;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\User;
use App\Services\CalendarEvent\EventRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventRegistrationService $service;
    protected User $user;
    protected Event $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new EventRegistrationService();
        $this->user = User::factory()->create();
        $this->event = Event::factory()->create([
            'title' => 'Test Event',
            'date' => now()->addDays(7),
            'max_participants' => 100,
        ]);
    }

    /** @test */
    public function can_check_if_user_already_registered()
    {
        // User not registered
        $this->assertFalse(
            $this->service->isAlreadyRegistered($this->user->id, $this->event->id)
        );

        // Create registration
        EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ]);

        // User is registered
        $this->assertTrue(
            $this->service->isAlreadyRegistered($this->user->id, $this->event->id)
        );
    }

    /** @test */
    public function can_register_user_for_event()
    {
        $registration = $this->service->register(
            $this->user->id,
            $this->event->id
        );

        $this->assertInstanceOf(EventRegistration::class, $registration);
        $this->assertEquals('registered', $registration->status);
        $this->assertEquals($this->user->id, $registration->user_id);
        $this->assertEquals($this->event->id, $registration->event_id);
        $this->assertNotNull($registration->qr_code);
        $this->assertNotNull($registration->attendance_code);
    }

    /** @test */
    public function qr_code_is_generated_on_registration()
    {
        $registration = $this->service->register(
            $this->user->id,
            $this->event->id
        );

        $this->assertNotNull($registration->qr_code);
        $this->assertNotEmpty($registration->qr_code);
    }

    /** @test */
    public function attendance_code_is_generated_on_registration()
    {
        $registration = $this->service->register(
            $this->user->id,
            $this->event->id
        );

        $this->assertNotNull($registration->attendance_code);
        $this->assertEquals(6, strlen($registration->attendance_code)); // 6-character code
    }

    /** @test */
    public function each_registration_has_unique_qr_code()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $registration1 = $this->service->register($user1->id, $this->event->id);
        $registration2 = $this->service->register($user2->id, $this->event->id);

        $this->assertNotEquals($registration1->qr_code, $registration2->qr_code);
    }

    /** @test */
    public function each_registration_has_unique_attendance_code()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $registration1 = $this->service->register($user1->id, $this->event->id);
        $registration2 = $this->service->register($user2->id, $this->event->id);

        $this->assertNotEquals($registration1->attendance_code, $registration2->attendance_code);
    }

    /** @test */
    public function cannot_register_if_already_registered()
    {
        // First registration
        EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ]);

        // Try to register again
        $registration = $this->service->register(
            $this->user->id,
            $this->event->id
        );

        $this->assertNull($registration);
    }

    /** @test */
    public function can_cancel_registered_event()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $result = $this->service->cancel($registration);

        $this->assertTrue($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function cannot_cancel_attended_event()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'attended',
        ]);

        $result = $this->service->cancel($registration);

        $this->assertFalse($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'attended',
        ]);
    }

    /** @test */
    public function can_mark_attendance_for_registered_participant()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $adminId = 1;
        $notes = 'Scanned QR code at entrance';
        $result = $this->service->markAttendance($registration, $adminId, $notes);

        $this->assertTrue($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'attended',
            'attendance_notes' => $notes,
            'attended_by' => $adminId,
        ]);

        $registration->refresh();
        $this->assertNotNull($registration->attended_at);
    }

    /** @test */
    public function cannot_mark_attendance_twice()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'attended',
            'attended_at' => now(),
        ]);

        $result = $this->service->markAttendance($registration, 1, 'Second attempt');

        $this->assertFalse($result);
    }

    /** @test */
    public function cannot_mark_attendance_for_cancelled_registration()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'cancelled',
        ]);

        $result = $this->service->markAttendance($registration, 1, 'Attempt');

        $this->assertFalse($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function attendance_notes_are_optional()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $result = $this->service->markAttendance($registration, 1, null);

        $this->assertTrue($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'attended',
        ]);
    }
}
