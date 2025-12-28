<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get published, upcoming events, ordered by date, paginated
        $events = Event::published()
            ->upcoming()
            ->orderBy('event_date', 'asc')
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after:now',
            'registration_deadline' => 'nullable|date|before:event_date',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        // Create the event (automatically sets user_id via relationship)
        $event = $request->user()->events()->create($validated);

        // Redirect to the event detail page with success message
        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the event or return 404
        $event = Event::findOrFail($id);

        // Check if user is authorized to update this event
        $this->authorize('update', $event);

        // Return the edit view with the event data
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the event by ID or return 404
        $event = Event::findOrFail($id);

        // Check if user is authorized to update this event
        $this->authorize('update', $event);

        // Validate the incoming request data (same rules as store)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date|after:now',
            'registration_deadline' => 'nullable|date|before:event_date',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        // Update the event with validated data
        $event->update($validated);

        // Redirect to the event detail page with success message
        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the event by ID or return 404
        $event = Event::findOrFail($id);

        // Check if user is authorized to delete this event
        $this->authorize('delete', $event);

        // Delete the event from the database
        $event->delete();

        // Redirect to the events list with success message
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
