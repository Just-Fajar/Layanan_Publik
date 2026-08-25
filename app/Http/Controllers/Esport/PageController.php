<?php

namespace App\Http\Controllers\Esport;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        return view('esport.pages.home');
    }

    public function about()
    {
        return view('esport.pages.about');
    }

    public function contact()
    {
        return view('esport.pages.contact');
    }
}
