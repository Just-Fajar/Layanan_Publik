<?php

namespace Tests\Unit\Policies;

use App\Models\Esport\TournamentRegistration;
use App\Models\User;
use App\Policies\TournamentRegistrationPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegistrationPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected TournamentRegistrationPolicy $policy;

    protected User $user;

    protected User $otherUser;

    protected TournamentRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new TournamentRegistrationPolicy;
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->registration = TournamentRegistration::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function user_can_view_own_registration()
    {
        $this->assertTrue(
            $this->policy->view($this->user, $this->registration)
        );
    }

    /** @test */
    public function user_cannot_view_other_users_registration()
    {
        $this->assertFalse(
            $this->policy->view($this->otherUser, $this->registration)
        );
    }

    /** @test */
    public function user_can_cancel_own_pending_registration()
    {
        $this->assertTrue(
            $this->policy->cancel($this->user, $this->registration)
        );
    }

    /** @test */
    public function user_cannot_cancel_other_users_registration()
    {
        $this->assertFalse(
            $this->policy->cancel($this->otherUser, $this->registration)
        );
    }

    /** @test */
    public function user_cannot_cancel_approved_registration()
    {
        $this->registration->update(['status' => 'approved']);

        $this->assertFalse(
            $this->policy->cancel($this->user, $this->registration)
        );
    }

    /** @test */
    public function user_cannot_cancel_rejected_registration()
    {
        $this->registration->update(['status' => 'rejected']);

        $this->assertFalse(
            $this->policy->cancel($this->user, $this->registration)
        );
    }

    /** @test */
    public function policy_returns_false_for_null_user()
    {
        $this->assertFalse(
            $this->policy->view(null, $this->registration)
        );

        $this->assertFalse(
            $this->policy->cancel(null, $this->registration)
        );
    }
}
