<?php

namespace Tests\Feature\Esport;

use App\Models\Admin;
use App\Models\Esport\TournamentRegistration;
use App\Models\News;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegistrationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected Admin $esportAdmin;

    protected Admin $calendarAdmin;

    protected User $user;

    protected Tournament $tournament;

    protected TournamentRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = Admin::factory()->superAdmin()->create();
        $this->esportAdmin = Admin::factory()->esport()->create();
        $this->calendarAdmin = Admin::factory()->calendar()->create();

        $this->user = User::factory()->create([
            'name' => 'Fajar Pratama',
            'email' => 'fajar@example.com',
            'username' => 'fajarpratama',
            'phone' => '081234567890',
        ]);

        $this->tournament = Tournament::factory()->create([
            'title' => 'Mobile Legends Championship 2026',
            'game' => 'Mobile Legends',
            'date' => now()->addDays(5),
            'location' => 'Main Hall',
            'status' => 'upcoming',
        ]);

        $this->registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'tournament_id' => $this->tournament->id,
            'status' => 'pending',
            'team_name' => 'Garuda Esports',
            'in_game_id' => 'GARUDA_001',
            'team_members' => ['Player One', 'Player Two', 'Player Three'],
        ]);
    }

    /**
     * Test guest is redirected to login when accessing esport admin routes.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('esport.admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('esport.admin.registrations.index'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('esport.admin.users.index'))
            ->assertRedirect(route('admin.login'));
    }

    /**
     * Test unauthorized admin (e.g. calendar admin) cannot access esport admin routes (403 Forbidden).
     */
    public function test_unauthorized_admin_cannot_access_esport_admin_routes(): void
    {
        $this->actingAs($this->calendarAdmin, 'admin')
            ->get(route('esport.admin.dashboard'))
            ->assertForbidden();

        $this->actingAs($this->calendarAdmin, 'admin')
            ->get(route('esport.admin.registrations.index'))
            ->assertForbidden();

        $this->actingAs($this->calendarAdmin, 'admin')
            ->get(route('esport.admin.users.index'))
            ->assertForbidden();
    }

    /**
     * Test esport admin can view dashboard with statistics.
     */
    public function test_esport_admin_can_view_dashboard_with_statistics(): void
    {
        News::create([
            'title' => 'Esport Tournament Announcement',
            'category' => 'Tournament Info',
            'content' => 'Official announcement content.',
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('esport.admin.dashboard');
        $response->assertViewHasAll([
            'statistics',
            'recent_registrations',
            'recent_users',
            'active_tournaments',
        ]);
        $response->assertSee('Mobile Legends Championship 2026');
        $response->assertSee('fajarpratama');
    }

    /**
     * Test super admin can also access esport admin dashboard.
     */
    public function test_super_admin_can_access_esport_admin_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin, 'admin')
            ->get(route('esport.admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('esport.admin.dashboard');
    }

    /**
     * Test esport admin can view registrations index.
     */
    public function test_esport_admin_can_view_registrations_index(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.registrations.index'));

        $response->assertOk();
        $response->assertViewIs('esport.admin.registrations.index');
        $response->assertSee('Garuda Esports');
        $response->assertSee('Fajar Pratama');
        $response->assertSee('Mobile Legends Championship 2026');
    }

    /**
     * Test esport admin can filter registrations by status.
     */
    public function test_esport_admin_can_filter_registrations_by_status(): void
    {
        $approvedReg = TournamentRegistration::factory()->approved()->create([
            'team_name' => 'Rex Regum Team',
            'tournament_id' => $this->tournament->id,
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.registrations.index', ['status' => 'approved']));

        $response->assertOk();
        $response->assertSee('Rex Regum Team');
        $response->assertDontSee('Garuda Esports');
    }

    /**
     * Test esport admin can search registrations.
     */
    public function test_esport_admin_can_search_registrations(): void
    {
        $otherReg = TournamentRegistration::factory()->create([
            'team_name' => 'Evos Legends',
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.registrations.index', ['search' => 'Garuda']));

        $response->assertOk();
        $response->assertSee('Garuda Esports');
        $response->assertDontSee('Evos Legends');
    }

    /**
     * Test esport admin can view registration detail.
     */
    public function test_esport_admin_can_view_registration_detail(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.registrations.show', $this->registration));

        $response->assertOk();
        $response->assertViewIs('esport.admin.registrations.show');
        $response->assertSee('Garuda Esports');
        $response->assertSee('Fajar Pratama');
        $response->assertSee('GARUDA_001');
        $response->assertSee('Player One');
    }

    /**
     * Test esport admin can approve pending registration.
     */
    public function test_esport_admin_can_approve_pending_registration(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->post(route('esport.admin.registrations.approve', $this->registration));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $this->registration->id,
            'status' => 'approved',
            'rejection_reason' => null,
        ]);
    }

    /**
     * Test esport admin can reject registration with reason.
     */
    public function test_esport_admin_can_reject_registration_with_reason(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->post(route('esport.admin.registrations.reject', $this->registration), [
                'rejection_reason' => 'Roster pemain belum lengkap',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tournament_registrations', [
            'id' => $this->registration->id,
            'status' => 'rejected',
            'rejection_reason' => 'Roster pemain belum lengkap',
        ]);
    }

    /**
     * Test reject registration requires rejection reason.
     */
    public function test_reject_registration_requires_rejection_reason(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->post(route('esport.admin.registrations.reject', $this->registration), [
                'rejection_reason' => '',
            ]);

        $response->assertSessionHasErrors('rejection_reason');
        $this->assertEquals('pending', $this->registration->fresh()->status);
    }

    /**
     * Test esport admin can view users index with registration counts.
     */
    public function test_esport_admin_can_view_users_index(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.users.index'));

        $response->assertOk();
        $response->assertViewIs('esport.admin.users.index');
        $response->assertSee('Fajar Pratama');
        $response->assertSee('fajar@example.com');
        $response->assertSee('1 registrations');
    }

    /**
     * Test esport admin can search users.
     */
    public function test_esport_admin_can_search_users(): void
    {
        $otherUser = User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'username' => 'sitinur',
        ]);

        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.users.index', ['search' => 'Fajar']));

        $response->assertOk();
        $response->assertSee('Fajar Pratama');
        $response->assertDontSee('Siti Nurhaliza');
    }

    /**
     * Test esport admin can view user detail with tournament registration history.
     */
    public function test_esport_admin_can_view_user_detail_with_history(): void
    {
        $response = $this->actingAs($this->esportAdmin, 'admin')
            ->get(route('esport.admin.users.show', $this->user));

        $response->assertOk();
        $response->assertViewIs('esport.admin.users.show');
        $response->assertSee('Fajar Pratama');
        $response->assertSee('Mobile Legends Championship 2026');
        $response->assertSee('Garuda Esports');
    }
}
