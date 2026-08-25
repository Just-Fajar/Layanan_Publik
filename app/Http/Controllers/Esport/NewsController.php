<?php

namespace App\Http\Controllers\Esport;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $r)
    {
        $filters = $r->only(['category', 'q']);
        $news = News::latest()->filter($filters)->paginate(9)->withQueryString();

        return view('esport.news.index', compact('news', 'filters'));
    }

    public function show(News $news)
    {
        return view('esport.news.show', compact('news'));
    }
}
