<?php

namespace Tests\Unit\Services;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
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

        $this->service = new EventRegistrationService;
        $this->user = User::factory()->create();
        $this->event = Event::factory()->create([
            'title' => 'Test Event',
            'max_participants' => 100,
        ]);
    }

    /** @test */
    public function can_check_if_user_already_registered()
    {
        // User not registered
        $this->assertFalse(
            $this->service->isAlreadyRegistered($this->user, $this->event)
        );

        // Create registration
        EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ]);

        // User is registered
        $this->assertTrue(
            $this->service->isAlreadyRegistered($this->user, $this->event)
        );
    }

    /** @test */
    public function can_register_user_for_event()
    {
        $registration = $this->service->register(
            $this->user,
            $this->event,
            ['notes' => 'Testing registration']
        );

        $this->assertInstanceOf(EventRegistration::class, $registration);
        $this->assertEquals('registered', $registration->status);
        $this->assertEquals($this->user->id, $registration->user_id);
        $this->assertEquals($this->event->id, $registration->event_id);
        $this->assertEquals('Testing registration', $registration->notes);
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
    public function cannot_cancel_already_attended_or_cancelled_event()
    {
        $attendedRegistration = EventRegistration::factory()->attended()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ]);

        $this->expectException(\Exception::class);
        $this->service->cancel($attendedRegistration);
    }

    /** @test */
    public function can_mark_attendance_with_registration_object()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $result = $this->service->markAttendance($registration);

        $this->assertTrue($result);
        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'attended',
        ]);
    }

    /** @test */
    public function can_mark_attendance_with_code()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'attendance_code' => 'CODE1234',
            'status' => 'registered',
        ]);

        $result = $this->service->markAttendance('CODE1234');

        $this->assertInstanceOf(EventRegistration::class, $result);
        $this->assertEquals('attended', $result->status);
    }

    /** @test */
    public function can_get_event_statistics()
    {
        EventRegistration::factory()->count(3)->create([
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        EventRegistration::factory()->count(2)->attended()->create([
            'event_id' => $this->event->id,
        ]);

        $stats = $this->service->getEventStatistics($this->event);

        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(3, $stats['registered']);
        $this->assertEquals(2, $stats['attended']);
        $this->assertEquals(40.0, $stats['attendance_rate']);
    }
}
