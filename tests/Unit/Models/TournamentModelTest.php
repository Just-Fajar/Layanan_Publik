<?php

namespace Tests\Unit\Models;

use App\Models\Esport\TournamentRegistration;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tournament_can_be_created_with_fillable_attributes(): void
    {
        $tournament = Tournament::create([
            'title' => 'M-GEN Mobile Legends Championship 2026',
            'game' => 'Mobile Legends',
            'date' => now()->addDays(7),
            'location' => 'Online & Offline Caruban',
            'description' => 'Turnamen esport resmi Diskominfo Kabupaten Madiun.',
            'status' => 'upcoming',
            'organizer_contact' => '081234567890',
        ]);

        $this->assertInstanceOf(Tournament::class, $tournament);
        $this->assertEquals('M-GEN Mobile Legends Championship 2026', $tournament->title);
        $this->assertEquals('Mobile Legends', $tournament->game);
        $this->assertEquals('upcoming', $tournament->status);
        $this->assertEquals($tournament->title, $tournament->name);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $tournament->date);
    }

    public function test_tournament_image_url_accessor(): void
    {
        $localTournament = new Tournament(['image' => 'tournaments/banner.png']);
        $this->assertStringContainsString('storage/tournaments/banner.png', $localTournament->image_url);

        $externalTournament = new Tournament(['image' => 'https://example.com/banner.png']);
        $this->assertEquals('https://example.com/banner.png', $externalTournament->image_url);

        $nullTournament = new Tournament(['image' => null]);
        $this->assertNull($nullTournament->image_url);
    }

    public function test_tournament_filter_scope(): void
    {
        $mlbb = Tournament::create([
            'title' => 'MLBB Tourney',
            'game' => 'Mobile Legends',
            'status' => 'upcoming',
            'location' => 'Caruban',
        ]);

        $pubg = Tournament::create([
            'title' => 'PUBG Mobile Tourney',
            'game' => 'PUBG Mobile',
            'status' => 'ongoing',
            'location' => 'Mejayan',
        ]);

        $filteredGame = Tournament::filter(['game' => 'Mobile Legends'])->get();
        $this->assertTrue($filteredGame->contains($mlbb));
        $this->assertFalse($filteredGame->contains($pubg));

        $filteredStatus = Tournament::filter(['status' => 'ongoing'])->get();
        $this->assertTrue($filteredStatus->contains($pubg));
        $this->assertFalse($filteredStatus->contains($mlbb));

        $filteredSearch = Tournament::filter(['q' => 'Mejayan'])->get();
        $this->assertTrue($filteredSearch->contains($pubg));
        $this->assertFalse($filteredSearch->contains($mlbb));
    }

    public function test_tournament_has_many_registrations(): void
    {
        $tournament = Tournament::create([
            'title' => 'Free Fire Battle',
            'game' => 'Free Fire',
            'status' => 'upcoming',
        ]);

        $user = User::factory()->create();

        $registration = TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'user_id' => $user->id,
            'team_name' => 'Garuda Madiun',
            'captain_name' => 'Fajar',
            'captain_phone' => '081234567890',
            'captain_email' => 'fajar@example.com',
            'status' => 'approved',
        ]);

        $this->assertTrue($tournament->registrations()->exists());
        $this->assertEquals($registration->id, $tournament->registrations->first()->id);
    }
}
