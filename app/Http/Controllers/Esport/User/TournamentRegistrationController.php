<?php

namespace App\Http\Controllers\Esport\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Esport\TournamentRegistrationRequest;
use App\Models\Esport\Tournament;
use App\Models\Esport\TournamentRegistration;
use App\Services\Esport\TournamentRegistrationService;
use Illuminate\Http\Request;

class TournamentRegistrationController extends Controller
{
    protected $registrationService;

    public function __construct(TournamentRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Display user's tournament registrations
     */
    public function index(Request $request)
    {
        $registrations = $this->registrationService->getUserRegistrations(auth()->user());

        return view('esport.user.tournaments.index', compact('registrations'));
    }

    /**
     * Register for a tournament
     */
    public function register(TournamentRegistrationRequest $request, Tournament $tournament)
    {
        try {
            // Check if already registered
            if ($this->registrationService->isAlreadyRegistered(auth()->user(), $tournament)) {
                return back()->with('error', 'You have already registered for this tournament.');
            }

            // Register
            $this->registrationService->register(
                auth()->user(),
                $tournament,
                $request->validated()
            );

            return redirect()
                ->route('esport.user.tournaments.index')
                ->with('success', 'Tournament registration submitted successfully! Please wait for admin approval.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to register: ' . $e->getMessage());
        }
    }

    /**
     * Cancel registration
     */
    public function cancel(TournamentRegistration $registration)
    {
        if (auth()->id() !== $registration->user_id) {
            abort(403);
        }

        try {
            $this->registrationService->cancel($registration);

            return back()->with('success', 'Registration cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel registration: ' . $e->getMessage());
        }
    }
}
