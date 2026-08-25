<?php

namespace Tests\Unit\Services;

use App\Models\Esport\TournamentRegistration;
use App\Models\Tournament;
use App\Models\User;
use App\Services\Esport\TournamentRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TournamentRegistrationService $service;

    protected User $user;

    protected Tournament $tournament;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new TournamentRegistrationService;
        $this->user = User::factory()->create();
        $this->tournament = Tournament::factory()->create([
            'title' => 'Test Tournament',
        ]);
    }

    /** @test */
    public function can_check_if_user_already_registered()
    {
        // User not registered
        $this->assertFalse(
            $this->service->isAlreadyRegistered($this->user, $this->tournament)
        );

        // Create registration
        TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        // User is registered
        $this->assertTrue(
            $this->service->isAlreadyRegistered($this->user, $this->tournament)
        );
    }

    /** @test */
    public function can_register_user_for_tournament()
    {
        $data = [
            'team_name' => 'Test Team',
            'in_game_id' => 'player123',
            'notes' => 'Excited to compete!',
        ];

        $registration = $this->service->register(
            $this->user,
            $this->tournament,
            $data
        );

        $this->assertInstanceOf(TournamentRegistration::class, $registration);
        $this->assertEquals('Test Team', $registration->team_name);
        $this->assertEquals('player123', $registration->in_game_id);
        $this->assertEquals('pending', $registration->status);
    }

    /** @test */
    public function can_cancel_pending_registration()
    {
        $registration = TournamentRegistration::factory()->pending()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        $result = $this->service->cancel($registration);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tournament_registrations', [
            'id' => $registration->id,
        ]);
    }

    /** @test */
    public function cannot_cancel_approved_or_rejected_registration()
    {
        $approvedRegistration = TournamentRegistration::factory()->approved()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        $this->expectException(\Exception::class);
        $this->service->cancel($approvedRegistration);
    }

    /** @test */
    public function can_approve_registration()
    {
        $registration = TournamentRegistration::factory()->pending()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        $result = $this->service->approve($registration);

        $this->assertTrue($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function can_reject_registration()
    {
        $registration = TournamentRegistration::factory()->pending()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        $result = $this->service->reject($registration, 'Incomplete roster');

        $this->assertTrue($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'rejected',
            'rejection_reason' => 'Incomplete roster',
        ]);
    }

    /** @test */
    public function can_get_tournament_statistics()
    {
        TournamentRegistration::factory()->count(3)->pending()->create([
            'tournament_id' => $this->tournament->id,
        ]);

        TournamentRegistration::factory()->count(2)->approved()->create([
            'tournament_id' => $this->tournament->id,
        ]);

        $stats = $this->service->getTournamentStatistics($this->tournament);

        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(3, $stats['pending']);
        $this->assertEquals(2, $stats['approved']);
    }
}
