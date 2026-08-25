<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of esport users/players.
     */
    public function index(Request $request)
    {
        $query = User::withCount('tournamentRegistrations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('esport.admin.users.index', compact('users'));
    }

    /**
     * Display the specified esport user/player.
     */
    public function show(User $user)
    {
        $user->load(['tournamentRegistrations.tournament']);

        return view('esport.admin.users.show', compact('user'));
    }
}
