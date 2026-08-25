<?php

namespace App\Http\Controllers\CalendarEvent\User;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Services\CalendarEvent\EventRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRegistrationController extends Controller
{
    protected EventRegistrationService $registrationService;

    public function __construct(EventRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Display user's event registrations
     */
    public function index(Request $request): View
    {
        $registrations = $this->registrationService->getUserRegistrations(auth()->user());

        return view('calendar.user.events.index', compact('registrations'));
    }

    /**
     * Display specific event registration
     */
    public function show(EventRegistration $registration): View
    {
        if (auth()->id() !== $registration->user_id) {
            abort(403);
        }

        $registration->load('event');

        return view('calendar.user.events.show', compact('registration'));
    }

    /**
     * Register for an event
     */
    public function register(Request $request, Event $event): RedirectResponse
    {
        try {
            // Check if already registered
            if ($this->registrationService->isAlreadyRegistered(auth()->user(), $event)) {
                return back()->with('error', 'You have already registered for this event.');
            }

            // Register
            $this->registrationService->register(
                auth()->user(),
                $event,
                $request->all()
            );

            return redirect()
                ->route('calendar.user.events.index')
                ->with('success', 'Event registration successful!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to register: ' . $e->getMessage());
        }
    }

    /**
     * Cancel registration
     */
    public function cancel(EventRegistration $registration): RedirectResponse
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
