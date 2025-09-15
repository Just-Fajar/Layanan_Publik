<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Models\Tournament;
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    public function index(){ $rows = Tournament::latest()->paginate(10); return view('esport.admin.tournaments.index', compact('rows')); }
    public function create(){ return view('esport.admin.tournaments.create'); }

    public function store(StoreTournamentRequest $r){
        $data = $r->validated();
        if ($r->hasFile('image')) $data['image'] = $r->file('image')->store('tournaments','public');
        Tournament::create($data);
        return redirect()->route('esport.admin.tournaments.index')->with('ok','Created');
    }

    public function edit(Tournament $tournament){ return view('esport.admin.tournaments.edit', compact('tournament')); }

    public function update(UpdateTournamentRequest $r, Tournament $tournament){
        $data = $r->validated();
        if ($r->hasFile('image')) {
            if ($tournament->image) Storage::disk('public')->delete($tournament->image);
            $data['image'] = $r->file('image')->store('tournaments','public');
        }
        $tournament->update($data);
        return redirect()->route('esport.admin.tournaments.index')->with('ok','Updated');
    }

    public function destroy(Tournament $tournament){
        if ($tournament->image) Storage::disk('public')->delete($tournament->image);
        $tournament->delete();
        return back()->with('ok','Deleted');
    }
}

