<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Event $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->event = Event::factory()->create([
            'title' => 'Test Event',
            'description' => 'Test event description',
            'date' => now()->addDays(7),
            'time' => '10:00:00',
            'location' => 'Test Location',
            'max_participants' => 100,
        ]);
    }

    /** @test */
    public function user_can_view_events_list()
    {
        $response = $this->actingAs($this->user)
            ->get(route('calendar.user.events.index'));

        $response->assertStatus(200);
        $response->assertViewIs('calendar.user.events.index');
    }

    /** @test */
    public function user_can_register_for_event()
    {
        $response = $this->actingAs($this->user)
            ->post(route('calendar.user.events.register', $this->event));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);
    }

    /** @test */
    public function event_registration_generates_qr_code()
    {
        $this->actingAs($this->user)
            ->post(route('calendar.user.events.register', $this->event));

        $registration = EventRegistration::where([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ])->first();

        $this->assertNotNull($registration);
        $this->assertNotNull($registration->qr_code);
        $this->assertNotNull($registration->attendance_code);
    }

    /** @test */
    public function user_cannot_register_for_same_event_twice()
    {
        // First registration
        EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        // Try to register again
        $response = $this->actingAs($this->user)
            ->post(route('calendar.user.events.register', $this->event));

        $response->assertSessionHas('error');

        // Should still have only 1 registration
        $this->assertEquals(1, EventRegistration::where([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
        ])->count());
    }

    /** @test */
    public function user_can_view_qr_code_for_registered_event()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
            'qr_code' => 'test_qr_code_data',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('calendar.user.events.index'));

        $response->assertStatus(200);
        $response->assertSee($this->event->title);
    }

    /** @test */
    public function user_can_cancel_registered_event()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('calendar.user.events.cancel', $registration));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function user_cannot_cancel_attended_event()
    {
        $registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'attended',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('calendar.user.events.cancel', $registration));

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'attended',
        ]);
    }

    /** @test */
    public function user_cannot_cancel_other_users_registration()
    {
        $otherUser = User::factory()->create();
        $registration = EventRegistration::factory()->create([
            'user_id' => $otherUser->id,
            'event_id' => $this->event->id,
            'status' => 'registered',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('calendar.user.events.cancel', $registration));

        $response->assertStatus(403); // Forbidden

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'status' => 'registered',
        ]);
    }

    /** @test */
    public function qr_code_is_unique_for_each_registration()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1)
            ->post(route('calendar.user.events.register', $this->event));

        $this->actingAs($user2)
            ->post(route('calendar.user.events.register', $this->event));

        $registration1 = EventRegistration::where('user_id', $user1->id)->first();
        $registration2 = EventRegistration::where('user_id', $user2->id)->first();

        $this->assertNotEquals($registration1->qr_code, $registration2->qr_code);
        $this->assertNotEquals($registration1->attendance_code, $registration2->attendance_code);
    }
}
