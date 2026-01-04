<?php

namespace App\Http\Controllers\BukuTamu;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the visitor form page.
     */
    public function visitor(): View
    {
        return view('buku_tamu.visitor');
    }
}
