<?php

namespace App\Http\Controllers\CalendarEvent\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent\EventRegistration;
use Illuminate\Http\Request;

class RegistrationManagementController extends Controller
{
    /**
     * Display a listing of event registrations.
     */
    public function index(Request $request)
    {
        $query = EventRegistration::with(['user', 'event']);

        // Count totals for tab counters
        $total_count = EventRegistration::count();
        $registered_count = EventRegistration::registered()->count();
        $attended_count = EventRegistration::attended()->count();
        $cancelled_count = EventRegistration::cancelled()->count();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by user name/email or event title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                })->orWhereHas('event', function ($eq) use ($search) {
                    $eq->where('title', 'like', "%{$search}%");
                })->orWhere('attendance_code', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(15);

        return view('calendar.admin.registrations.index', compact(
            'registrations',
            'total_count',
            'registered_count',
            'attended_count',
            'cancelled_count'
        ));
    }

    /**
     * Display the specified registration details.
     */
    public function show(EventRegistration $registration)
    {
        $registration->load(['user', 'event.registrations']);

        return view('calendar.admin.registrations.show', compact('registration'));
    }

    /**
     * Mark the specified registration as attended.
     */
    public function attend(EventRegistration $registration)
    {
        if ($registration->status === 'cancelled') {
            return back()->with('error', 'Registrasi yang sudah dibatalkan tidak dapat diverifikasi kehadirannya.');
        }

        if ($registration->status === 'attended') {
            return back()->with('error', 'Peserta ini sudah diverifikasi kehadirannya sebelumnya.');
        }

        $registration->markAttended();

        return back()->with('success', 'Kehadiran peserta berhasil diverifikasi.');
    }

    /**
     * Cancel the specified registration.
     */
    public function cancel(EventRegistration $registration)
    {
        $registration->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Pendaftaran event berhasil dibatalkan.');
    }
}
