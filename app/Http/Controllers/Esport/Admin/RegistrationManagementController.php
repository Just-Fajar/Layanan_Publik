<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Models\Esport\TournamentRegistration;
use Illuminate\Http\Request;

class RegistrationManagementController extends Controller
{
    /**
     * Display a listing of tournament registrations.
     */
    public function index(Request $request)
    {
        $total_count = TournamentRegistration::count();
        $pending_count = TournamentRegistration::pending()->count();
        $approved_count = TournamentRegistration::approved()->count();
        $rejected_count = TournamentRegistration::rejected()->count();

        $query = TournamentRegistration::with(['user', 'tournament']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('team_name', 'like', "%{$search}%")
                    ->orWhere('in_game_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tournament', function ($tq) use ($search) {
                        $tq->where('title', 'like', "%{$search}%")
                            ->orWhere('game', 'like', "%{$search}%");
                    });
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();

        return view('esport.admin.registrations.index', compact(
            'registrations',
            'total_count',
            'pending_count',
            'approved_count',
            'rejected_count'
        ));
    }

    /**
     * Display the specified tournament registration.
     */
    public function show(TournamentRegistration $registration)
    {
        $registration->load(['user', 'tournament']);

        return view('esport.admin.registrations.show', compact('registration'));
    }

    /**
     * Approve the specified tournament registration.
     */
    public function approve(TournamentRegistration $registration)
    {
        $registration->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Registration has been approved successfully.');
    }

    /**
     * Reject the specified tournament registration.
     */
    public function reject(Request $request, TournamentRegistration $registration)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $registration->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Registration has been rejected successfully.');
    }
}
