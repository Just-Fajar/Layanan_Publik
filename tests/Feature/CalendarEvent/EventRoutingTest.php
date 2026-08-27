<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\Admin;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRoutingTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected Admin $calendarAdmin;

    protected Admin $bukuTamuAdmin;

    protected Event $publishedEvent;

    protected Event $draftEvent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = Admin::factory()->superAdmin()->create();
        $this->calendarAdmin = Admin::factory()->calendar()->create();
        $this->bukuTamuAdmin = Admin::factory()->bukuTamu()->create();

        $this->publishedEvent = Event::factory()->published()->create([
            'title' => 'Sosialisasi Smart City Madiun',
            'category' => 'workshop',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
        ]);

        $this->draftEvent = Event::factory()->draft()->create([
            'title' => 'Rapat Internal Draft',
            'category' => 'seminar',
        ]);
    }

    /**
     * Test public user can access calendar event catalogue index.
     */
    public function test_public_user_can_access_calendar_index(): void
    {
        $response = $this->get('/calendar');

        $response->assertStatus(200);
        $response->assertSee('Sosialisasi Smart City Madiun');
    }

    /**
     * Test public user can access monthly calendar view.
     */
    public function test_public_user_can_access_monthly_calendar_view(): void
    {
        $response = $this->get('/calendar/view/month');

        $response->assertStatus(200);
        $response->assertSee('Agenda Bulan');
    }

    /**
     * Test public user can view published event detail.
     */
    public function test_public_user_can_view_published_event_detail(): void
    {
        $response = $this->get('/calendar/' . $this->publishedEvent->id);

        $response->assertStatus(200);
        $response->assertSee('Sosialisasi Smart City Madiun');
    }

    /**
     * Test public user receives 404 when viewing draft event.
     */
    public function test_public_user_cannot_view_draft_event(): void
    {
        $response = $this->get('/calendar/' . $this->draftEvent->id);

        $response->assertStatus(404);
    }

    /**
     * Test guest is redirected to login when accessing admin calendar.
     */
    public function test_guest_is_redirected_when_accessing_admin_calendar(): void
    {
        $response = $this->get('/buku-tamu/admin/calendar/events');

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test Buku Tamu admin is forbidden from accessing Calendar admin panel (403).
     */
    public function test_buku_tamu_admin_is_forbidden_from_calendar_admin(): void
    {
        $response = $this->actingAs($this->bukuTamuAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/events');

        $response->assertStatus(403);
    }

    /**
     * Test Calendar Admin can access calendar admin events index.
     */
    public function test_calendar_admin_can_access_admin_events_index(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/events');

        $response->assertStatus(200);
        $response->assertSee('Kelola Events');
    }

    /**
     * Test Calendar Admin can view create event form.
     */
    public function test_calendar_admin_can_view_create_event_form(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->get('/buku-tamu/admin/calendar/events/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Event Baru');
    }

    /**
     * Test Calendar Admin can store new event.
     */
    public function test_calendar_admin_can_store_new_event(): void
    {
        $eventData = [
            'title' => 'Workshop Keamanan Siber',
            'category' => 'workshop',
            'description' => 'Pelatihan keamanan siber bagi ASN',
            'location' => 'Ruang Rapat GCIO',
            'start_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'status' => 'published',
        ];

        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->post('/buku-tamu/admin/calendar/events', $eventData);

        $response->assertRedirect(route('calendar.admin.events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Workshop Keamanan Siber',
            'category' => 'workshop',
        ]);
    }

    /**
     * Test Calendar Admin can update an existing event.
     */
    public function test_calendar_admin_can_update_event(): void
    {
        $updatedData = [
            'title' => 'Sosialisasi Smart City Madiun (Updated)',
            'category' => 'workshop',
            'description' => 'Deskripsi kegiatan yang telah diperbarui',
            'location' => 'Aula Kominfo',
            'start_date' => now()->addDays(5)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(6)->format('Y-m-d H:i:s'),
            'status' => 'published',
        ];

        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->put('/buku-tamu/admin/calendar/events/' . $this->publishedEvent->id, $updatedData);

        $response->assertRedirect(route('calendar.admin.events.index'));
        $this->assertDatabaseHas('events', [
            'id' => $this->publishedEvent->id,
            'title' => 'Sosialisasi Smart City Madiun (Updated)',
        ]);
    }

    /**
     * Test Calendar Admin can delete an event.
     */
    public function test_calendar_admin_can_delete_event(): void
    {
        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->delete('/buku-tamu/admin/calendar/events/' . $this->draftEvent->id);

        $response->assertRedirect(route('calendar.admin.events.index'));
        $this->assertSoftDeleted('events', [
            'id' => $this->draftEvent->id,
        ]);
    }

    /**
     * Test Calendar Admin can perform bulk action on events.
     */
    public function test_calendar_admin_can_perform_bulk_actions(): void
    {
        $event1 = Event::factory()->draft()->create();
        $event2 = Event::factory()->draft()->create();

        $response = $this->actingAs($this->calendarAdmin, 'admin')
            ->post('/buku-tamu/admin/calendar/events/bulk', [
                'action' => 'publish',
                'event_ids' => [$event1->id, $event2->id],
            ]);

        $response->assertRedirect(route('calendar.admin.events.index'));
        $this->assertEquals(Event::STATUS_PUBLISHED, $event1->fresh()->status);
        $this->assertEquals(Event::STATUS_PUBLISHED, $event2->fresh()->status);
    }

    /**
     * Test authenticated user can access calendar user dashboard.
     */
    public function test_authenticated_user_can_access_calendar_user_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('calendar.user.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('My Registered Events');
        $response->assertSee('Browse Events');
        $response->assertSee('Edit Profile');
    }
}
