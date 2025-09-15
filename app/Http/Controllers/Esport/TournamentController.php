<?php

namespace App\Http\Controllers\Esport;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index(Request $r)
    {
        $filters = $r->only(['game','status','q']);
        $tournaments = Tournament::latest()->filter($filters)->paginate(9)->withQueryString();
        return view('esport.tournaments.index', compact('tournaments','filters'));
    }

    public function show(Tournament $tournament)
    {
        return view('esport.tournaments.show', compact('tournament'));
    }
}

