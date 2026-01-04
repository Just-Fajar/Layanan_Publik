<?php

namespace App\Http\Controllers\Esport\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        return view('esport.user.dashboard');
    }
}
