<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('buku_tamu.admin.login');
    }

    /**
     * Show dashboard page
     */
    public function dashboard()
    {
        return view('buku_tamu.admin.dashboard');
    }

    /**
     * Show calendar page
     */
    public function calendar()
    {
        return view('buku_tamu.admin.calendar');
    }
}
