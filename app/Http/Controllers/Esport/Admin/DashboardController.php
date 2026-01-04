<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Models\Esport\Tournament;
use App\Models\Esport\TournamentRegistration;
use App\Models\News;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display E-sport admin dashboard with statistics
     */
    public function index()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_tournaments' => Tournament::count(),
            'total_registrations' => TournamentRegistration::count(),
            'pending_registrations' => TournamentRegistration::pending()->count(),
            'approved_registrations' => TournamentRegistration::approved()->count(),
            'rejected_registrations' => TournamentRegistration::rejected()->count(),
            'total_news' => News::count(),
        ];

        // Recent registrations
        $recent_registrations = TournamentRegistration::with(['user', 'tournament'])
            ->latest()
            ->take(10)
            ->get();

        // Recent users
        $recent_users = User::latest()->take(5)->get();

        // Active tournaments
        $active_tournaments = Tournament::where('end_date', '>=', now())
            ->where('is_active', true)
            ->withCount('registrations')
            ->take(5)
            ->get();

        return view('esport.admin.dashboard', compact(
            'statistics',
            'recent_registrations',
            'recent_users',
            'active_tournaments'
        ));
    }
}
