<?php

namespace App\Http\Controllers\CalendarEvent\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index(): View
    {
        return view('calendar.user.dashboard');
    }
}
