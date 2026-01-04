<?php

namespace App\Http\Controllers\CalendarEvent;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request)
    {
        $perPage = config('pagination.web.events');
        $events = Event::published()
            ->filter($request->only(['category', 'month', 'year', 'search']))
            ->orderBy('start_date', 'asc')
            ->paginate($perPage);

        $categories = config('calendar_event.categories');

        return view('calendar_event.index', compact('events', 'categories'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Only show published events to public
        if ($event->status !== Event::STATUS_PUBLISHED) {
            abort(404);
        }

        return view('calendar_event.show', compact('event'));
    }

    /**
     * Display calendar view of events.
     */
    public function calendar(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $events = Event::published()
            ->whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->orderBy('start_date')
            ->get();

        return view('calendar_event.calendar', compact('events', 'year', 'month'));
    }
}
