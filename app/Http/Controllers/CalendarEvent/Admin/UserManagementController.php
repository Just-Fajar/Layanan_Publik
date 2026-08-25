<?php

namespace App\Http\Controllers\CalendarEvent\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users with event registration statistics.
     */
    public function index(Request $request)
    {
        $query = User::withCount('eventRegistrations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('calendar.admin.users.index', compact('users'));
    }

    /**
     * Display the specified user details and activity.
     */
    public function show(User $user)
    {
        $user->load(['eventRegistrations.event']);

        return view('calendar.admin.users.show', compact('user'));
    }
}
