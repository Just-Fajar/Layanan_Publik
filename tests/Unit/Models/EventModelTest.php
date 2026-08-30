<?php

namespace Tests\Unit\Models;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_can_be_created_with_proper_attributes_and_casts(): void
    {
        $event = Event::create([
            'title' => 'Festival Budaya Madiun 2026',
            'description' => 'Perayaan seni dan budaya khas Kabupaten Madiun.',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'location' => 'Alun-alun Reksogati Caruban',
            'category' => 'exhibition',
            'organizer' => 'Diskominfo Madiun',
            'status' => Event::STATUS_PUBLISHED,
            'max_participants' => 200,
            'is_public' => true,
        ]);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('Festival Budaya Madiun 2026', $event->title);
        $this->assertTrue($event->is_public);
        $this->assertEquals(200, $event->max_participants);
        $this->assertTrue($event->is_upcoming);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $event->start_date);
    }

    public function test_event_published_and_upcoming_scopes(): void
    {
        $publishedFuture = Event::create([
            'title' => 'Event Masa Depan',
            'description' => 'Deskripsi event',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(11),
            'location' => 'Madiun',
            'category' => 'seminar',
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $draftFuture = Event::create([
            'title' => 'Event Draft',
            'description' => 'Deskripsi draft',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'location' => 'Madiun',
            'category' => 'workshop',
            'status' => Event::STATUS_DRAFT,
        ]);

        $publishedPast = Event::create([
            'title' => 'Event Masa Lalu',
            'description' => 'Deskripsi event lalu',
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(4),
            'location' => 'Madiun',
            'category' => 'conference',
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $publishedEvents = Event::published()->get();
        $this->assertTrue($publishedEvents->contains($publishedFuture));
        $this->assertTrue($publishedEvents->contains($publishedPast));
        $this->assertFalse($publishedEvents->contains($draftFuture));

        $upcomingEvents = Event::upcoming()->get();
        $this->assertTrue($upcomingEvents->contains($publishedFuture));
        $this->assertFalse($upcomingEvents->contains($publishedPast));
        $this->assertFalse($upcomingEvents->contains($draftFuture));
    }

    public function test_event_image_url_accessor(): void
    {
        $localEvent = new Event(['image' => 'events/banner.jpg']);
        $this->assertStringContainsString('storage/events/banner.jpg', $localEvent->image_url);

        $externalEvent = new Event(['image' => 'https://example.com/banner.jpg']);
        $this->assertEquals('https://example.com/banner.jpg', $externalEvent->image_url);

        $nullEvent = new Event(['image' => null]);
        $this->assertNull($nullEvent->image_url);
    }

    public function test_event_has_many_registrations_relationship(): void
    {
        $event = Event::create([
            'title' => 'Sosialisasi SPBE',
            'description' => 'Sosialisasi aplikasi SPBE',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3),
            'location' => 'Gedung Diskominfo',
            'category' => 'workshop',
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $user = User::factory()->create();

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'attendance_code' => 'QR-EVT-001',
            'status' => 'registered',
        ]);

        $this->assertTrue($event->registrations()->exists());
        $this->assertEquals($registration->id, $event->registrations->first()->id);
    }
}
