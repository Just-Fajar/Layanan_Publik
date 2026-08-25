<?php

namespace App\Http\Controllers\CalendarEvent\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent\EventRegistration;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display Calendar Event admin dashboard with statistics
     */
    public function index()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'total_registrations' => EventRegistration::count(),
            'registered' => EventRegistration::registered()->count(),
            'attended' => EventRegistration::attended()->count(),
            'cancelled' => EventRegistration::cancelled()->count(),
        ];

        // Calculate attendance rate
        $statistics['attendance_rate'] = $statistics['total_registrations'] > 0
            ? round(($statistics['attended'] / $statistics['total_registrations']) * 100, 2)
            : 0;

        // Recent registrations
        $recent_registrations = EventRegistration::with(['user', 'event'])
            ->latest()
            ->take(10)
            ->get();

        // Recent users
        $recent_users = User::latest()->take(5)->get();

        // Upcoming events
        $upcoming_events = Event::published()
            ->where('start_date', '>=', now())
            ->withCount('registrations')
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('calendar.admin.dashboard', compact(
            'statistics',
            'recent_registrations',
            'recent_users',
            'upcoming_events'
        ));
    }
}
