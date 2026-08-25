<?php

namespace Tests\Unit\Policies;

use App\Models\CalendarEvent\EventRegistration;
use App\Models\User;
use App\Policies\EventRegistrationPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected EventRegistrationPolicy $policy;

    protected User $user;

    protected User $otherUser;

    protected EventRegistration $registration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->policy = new EventRegistrationPolicy;
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->registration = EventRegistration::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'registered',
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
    public function user_can_cancel_own_registered_event()
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
    public function user_cannot_cancel_attended_event()
    {
        $this->registration->update(['status' => 'attended']);

        $this->assertFalse(
            $this->policy->cancel($this->user, $this->registration)
        );
    }

    /** @test */
    public function user_cannot_cancel_already_cancelled_event()
    {
        $this->registration->update(['status' => 'cancelled']);

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
