<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class EkspresiController extends Controller
{
    /**
     * Display the ekspresi page.
     */
    public function index(): View
    {
        return view('ekspresi');
    }
}
