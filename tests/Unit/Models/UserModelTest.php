<?php

namespace Tests\Unit\Models;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\Esport\TournamentRegistration;
use App\Models\Event;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_fillable_attributes(): void
    {
        $user = User::create([
            'name' => 'Ahmad Fauzi',
            'username' => 'ahmadfauzi',
            'email' => 'ahmad@example.com',
            'phone' => '081298765432',
            'password' => 'secret123',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Ahmad Fauzi', $user->name);
        $this->assertEquals('ahmadfauzi', $user->username);
        $this->assertEquals('ahmad@example.com', $user->email);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('secret123', $user->password));
    }

    public function test_user_has_many_event_registrations(): void
    {
        $user = User::factory()->create();
        $event = Event::create([
            'title' => 'Workshop Literasi Digital',
            'description' => 'Workshop digital',
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(3),
            'category' => 'workshop',
            'status' => Event::STATUS_PUBLISHED,
        ]);

        $reg = EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'attendance_code' => 'QR-999',
            'status' => 'registered',
        ]);

        $this->assertTrue($user->eventRegistrations()->exists());
        $this->assertEquals($reg->id, $user->eventRegistrations->first()->id);
    }

    public function test_user_has_many_tournament_registrations(): void
    {
        $user = User::factory()->create();
        $tournament = Tournament::create([
            'title' => 'PUBG Mobile Cup',
            'game' => 'PUBG Mobile',
            'status' => 'upcoming',
        ]);

        $reg = TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'user_id' => $user->id,
            'team_name' => 'Madiun Squad',
            'captain_name' => 'Ahmad',
            'captain_phone' => '081298765432',
            'captain_email' => 'ahmad@example.com',
            'status' => 'pending',
        ]);

        $this->assertTrue($user->tournamentRegistrations()->exists());
        $this->assertEquals($reg->id, $user->tournamentRegistrations->first()->id);
    }
}
