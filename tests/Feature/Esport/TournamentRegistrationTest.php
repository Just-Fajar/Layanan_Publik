<?php

namespace Tests\Feature\Esport;

use App\Models\Tournament;
use App\Models\Esport\TournamentRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tournament $tournament;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->tournament = Tournament::factory()->create([
            'name' => 'Test Tournament',
            'game' => 'Mobile Legends',
            'tournament_type' => 'team',
            'max_participants' => 100,
            'registration_start' => now()->subDays(1),
            'registration_end' => now()->addDays(7),
            'tournament_start' => now()->addDays(10),
        ]);
    }

    /** @test */
    public function user_can_view_tournaments_list()
    {
        $response = $this->actingAs($this->user)
            ->get(route('esport.user.tournaments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.user.tournaments.index');
    }

    /** @test */
    public function user_can_register_for_tournament()
    {
        $registrationData = [
            'team_name' => 'Test Team',
            'in_game_id' => 'player123',
            'notes' => 'Looking forward to compete!',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('esport.user.tournaments.register', $this->tournament), $registrationData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_registrations', [
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'team_name' => 'Test Team',
            'in_game_id' => 'player123',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function user_cannot_register_for_same_tournament_twice()
    {
        // First registration
        TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        // Try to register again
        $registrationData = [
            'team_name' => 'Test Team 2',
            'in_game_id' => 'player456',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('esport.user.tournaments.register', $this->tournament), $registrationData);

        $response->assertSessionHas('error');

        // Should still have only 1 registration
        $this->assertEquals(1, TournamentRegistration::where([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ])->count());
    }

    /** @test */
    public function user_can_cancel_pending_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('esport.user.tournaments.cancel', $registration));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tournament_registrations', [
            'id' => $registration->id,
        ]);
    }

    /** @test */
    public function user_cannot_cancel_approved_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('esport.user.tournaments.cancel', $registration));

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function user_cannot_cancel_other_users_registration()
    {
        $otherUser = User::factory()->create();
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $otherUser->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('esport.user.tournaments.cancel', $registration));

        $response->assertStatus(403); // Forbidden

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
        ]);
    }

    /** @test */
    public function registration_requires_team_name_for_team_tournaments()
    {
        $registrationData = [
            'in_game_id' => 'player123',
            // Missing team_name
        ];

        $response = $this->actingAs($this->user)
            ->post(route('esport.user.tournaments.register', $this->tournament), $registrationData);

        $response->assertSessionHasErrors('team_name');
    }

    /** @test */
    public function registration_requires_in_game_id()
    {
        $registrationData = [
            'team_name' => 'Test Team',
            // Missing in_game_id
        ];

        $response = $this->actingAs($this->user)
            ->post(route('esport.user.tournaments.register', $this->tournament), $registrationData);

        $response->assertSessionHasErrors('in_game_id');
    }

    /** @test */
    public function user_can_view_registration_status()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('esport.user.tournaments.index'));

        $response->assertStatus(200);
        $response->assertSee($this->tournament->name);
        $response->assertSee('pending');
    }
}
