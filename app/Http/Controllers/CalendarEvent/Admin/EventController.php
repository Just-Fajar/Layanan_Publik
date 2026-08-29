<?php

namespace App\Http\Controllers\CalendarEvent\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarEvent\StoreEventRequest;
use App\Http\Requests\CalendarEvent\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index(Request $request)
    {
        $perPage = config('pagination.admin.events');
        $events = Event::filter($request->only(['category', 'status', 'search']))
            ->latest()
            ->paginate($perPage);

        $categories = config('calendar_event.categories');

        return view('calendar_event.admin.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $categories = config('calendar_event.categories');

        return view('calendar_event.admin.create', compact('categories'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $this->authorizeForUser(auth('admin')->user(), 'create', Event::class);

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('calendar.admin.events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('calendar_event.admin.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $this->authorizeForUser(auth('admin')->user(), 'update', $event);

        $categories = config('calendar_event.categories');

        return view('calendar_event.admin.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorizeForUser(auth('admin')->user(), 'update', $event);

        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('calendar.admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorizeForUser(auth('admin')->user(), 'delete', $event);

        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()
            ->route('calendar.admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    /**
     * Bulk action for events.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $events = Event::whereIn('id', $request->event_ids);

        switch ($request->action) {
            case 'delete':
                foreach ($events->get() as $event) {
                    if ($event->image) {
                        Storage::disk('public')->delete($event->image);
                    }
                }
                $events->delete();
                $message = 'Events berhasil dihapus.';

                break;

            case 'publish':
                $events->update(['status' => Event::STATUS_PUBLISHED]);
                $message = 'Events berhasil dipublikasi.';

                break;

            case 'draft':
                $events->update(['status' => Event::STATUS_DRAFT]);
                $message = 'Events berhasil diubah ke draft.';

                break;
        }

        return redirect()
            ->route('calendar.admin.events.index')
            ->with('success', $message);
    }
}
