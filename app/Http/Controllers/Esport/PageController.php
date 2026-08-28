<?php

namespace App\Http\Controllers\Esport;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tournament;

class PageController extends Controller
{
    public function home()
    {
        $featuredTournaments = Tournament::latest()->take(3)->get();
        $latestNews = News::latest()->take(3)->get();

        return view('esport.pages.home', compact('featuredTournaments', 'latestNews'));
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
