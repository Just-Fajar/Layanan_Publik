<?php

namespace Tests\Feature\Esport\Admin;

use App\Models\Admin;
use App\Models\Esport\TournamentRegistration;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected User $user;

    protected Tournament $tournament;

    protected TournamentRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::factory()->esport()->create([
            'username' => 'esport_admin',
            'password' => bcrypt('password'),
        ]);

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
        ]);

        $this->tournament = Tournament::factory()->create([
            'title' => 'Test Tournament',
            'status' => 'upcoming',
        ]);

        $this->registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
            'team_name' => 'Test Team',
            'in_game_id' => 'player123',
        ]);
    }

    /** @test */
    public function admin_can_view_registrations_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.registrations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('esport.admin.registrations.index');
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function admin_can_filter_registrations_by_status()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.registrations.index', ['status' => 'pending']));

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function admin_can_view_registration_details()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.registrations.show', $this->registration));

        $response->assertStatus(200);
        $response->assertViewIs('esport.admin.registrations.show');
        $response->assertSee($this->user->name);
        $response->assertSee($this->tournament->name);
        $response->assertSee('Test Team');
        $response->assertSee('player123');
    }

    /** @test */
    public function admin_can_approve_pending_registration()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('esport.admin.registrations.approve', $this->registration));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $this->registration->id,
            'status' => 'approved',
        ]);

        $updated = $this->registration->fresh();
        $this->assertEquals('approved', $updated->status);
    }

    /** @test */
    public function admin_can_reject_pending_registration_with_reason()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('esport.admin.registrations.reject', $this->registration), [
                'rejection_reason' => 'Incomplete team roster',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $this->registration->id,
            'status' => 'rejected',
            'rejection_reason' => 'Incomplete team roster',
        ]);

        $updated = $this->registration->fresh();
        $this->assertEquals('rejected', $updated->status);
    }

    /** @test */
    public function rejection_requires_reason()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('esport.admin.registrations.reject', $this->registration), [
                'rejection_reason' => '', // Empty reason
            ]);

        $response->assertSessionHasErrors('rejection_reason');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $this->registration->id,
            'status' => 'pending', // Status unchanged
        ]);
    }

    /** @test */
    public function guest_cannot_access_admin_routes()
    {
        $response = $this->get(route('esport.admin.registrations.index'));

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_dashboard_shows_correct_statistics()
    {
        // Create more registrations with different statuses
        TournamentRegistration::factory()->create([
            'tournament_id' => $this->tournament->id,
            'status' => 'approved',
        ]);
        TournamentRegistration::factory()->create([
            'tournament_id' => $this->tournament->id,
            'status' => 'rejected',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('statistics');

        $statistics = $response->viewData('statistics');
        $this->assertArrayHasKey('total_registrations', $statistics);
        $this->assertArrayHasKey('pending_registrations', $statistics);
        $this->assertArrayHasKey('approved_registrations', $statistics);
        $this->assertArrayHasKey('rejected_registrations', $statistics);
    }
}
