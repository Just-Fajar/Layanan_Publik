<?php

namespace Tests\Unit\Services;

use App\Models\Tournament;
use App\Models\Esport\TournamentRegistration;
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

        $this->service = new TournamentRegistrationService();
        $this->user = User::factory()->create();
        $this->tournament = Tournament::factory()->create([
            'name' => 'Test Tournament',
            'tournament_type' => 'team',
            'max_participants' => 100,
        ]);
    }

    /** @test */
    public function can_check_if_user_already_registered()
    {
        // User not registered
        $this->assertFalse(
            $this->service->isAlreadyRegistered($this->user->id, $this->tournament->id)
        );

        // Create registration
        TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        // User is registered
        $this->assertTrue(
            $this->service->isAlreadyRegistered($this->user->id, $this->tournament->id)
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
            $this->user->id,
            $this->tournament->id,
            $data
        );

        $this->assertInstanceOf(TournamentRegistration::class, $registration);
        $this->assertEquals('Test Team', $registration->team_name);
        $this->assertEquals('player123', $registration->in_game_id);
        $this->assertEquals('pending', $registration->status);
        $this->assertEquals($this->user->id, $registration->user_id);
        $this->assertEquals($this->tournament->id, $registration->tournament_id);
    }

    /** @test */
    public function cannot_register_if_already_registered()
    {
        // First registration
        TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
        ]);

        // Try to register again
        $data = [
            'team_name' => 'Another Team',
            'in_game_id' => 'player456',
        ];

        $registration = $this->service->register(
            $this->user->id,
            $this->tournament->id,
            $data
        );

        $this->assertNull($registration);
    }

    /** @test */
    public function can_cancel_pending_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $result = $this->service->cancel($registration);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tournament_registrations', [
            'id' => $registration->id,
        ]);
    }

    /** @test */
    public function cannot_cancel_approved_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'approved',
        ]);

        $result = $this->service->cancel($registration);

        $this->assertFalse($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function cannot_cancel_rejected_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'rejected',
        ]);

        $result = $this->service->cancel($registration);

        $this->assertFalse($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'rejected',
        ]);
    }

    /** @test */
    public function can_approve_pending_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $adminId = 1;
        $result = $this->service->approve($registration, $adminId);

        $this->assertTrue($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
            'approved_by' => $adminId,
        ]);

        $registration->refresh();
        $this->assertNotNull($registration->approved_at);
    }

    /** @test */
    public function can_reject_pending_registration_with_reason()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
        ]);

        $adminId = 1;
        $reason = 'Incomplete team roster';
        $result = $this->service->reject($registration, $adminId, $reason);

        $this->assertTrue($result);
        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $registration->id,
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_by' => $adminId,
        ]);

        $registration->refresh();
        $this->assertNotNull($registration->rejected_at);
    }

    /** @test */
    public function cannot_approve_already_approved_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'approved',
        ]);

        $result = $this->service->approve($registration, 1);

        $this->assertFalse($result);
    }

    /** @test */
    public function cannot_reject_already_rejected_registration()
    {
        $registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'rejected',
        ]);

        $result = $this->service->reject($registration, 1, 'New reason');

        $this->assertFalse($result);
    }
}
