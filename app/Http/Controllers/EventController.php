<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCreatedMail;
use App\Mail\EventUpdatedMail;
use App\Services\XmlEventService;
use App\Events\EventCreated;
use App\Events\EventUpdated;
use App\Events\EventDeleted;

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

        // Send email confirmation
        Mail::to($request->user())->send(new EventCreatedMail($event));

        // Broadcast event creation
        broadcast(new EventCreated($event));

        // Redirect to the event detail page with success message
        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the event by ID or return 404 if not found
        $event = Event::findOrFail($id);

        // Check if user is authorized to view this event (policy check)
        $this->authorize('view', $event);

        // Return the show view with the event data
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

        // Send email notification
        Mail::to($request->user())->send(new EventUpdatedMail($event));

        // Broadcast event update
        broadcast(new EventUpdated($event));

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

        // Store event info before deletion
        $eventId = $event->id;
        $eventTitle = $event->title;

        // Delete the event from the database
        $event->delete();

        // Broadcast event deletion
        broadcast(new EventDeleted($eventId, $eventTitle));

        // Redirect to the events list with success message
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Export user's events to XML.
     */
    public function export(XmlEventService $xmlService)
    {
        // Get all events for the current user
        $events = auth()->user()->events;

        // Generate XML
        $xml = $xmlService->exportToXml($events);

        // Return as downloadable file
        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'attachment; filename="my-events-' . date('Y-m-d') . '.xml"',
        ]);
    }

    /**
     * Show the import form.
     */
    public function import()
    {
        return view('events.import');
    }

    /**
     * Process the XML import.
     */
    public function processImport(Request $request, XmlEventService $xmlService)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:2048',
        ]);

        try {
            // Read the uploaded file
            $xmlContent = file_get_contents($request->file('xml_file')->getRealPath());

            // Validate XML structure
            if (!$xmlService->validateXmlStructure($xmlContent)) {
                return back()->withErrors(['xml_file' => 'Invalid XML structure. Please check the format.']);
            }

            // Import events
            $result = $xmlService->importFromXml($xmlContent, auth()->id());

            $message = "Successfully imported {$result['success']} event(s).";

            if (!empty($result['errors'])) {
                $message .= " " . count($result['errors']) . " error(s) occurred.";
            }

            return redirect()->route('events.index')
                ->with('success', $message)
                ->with('import_errors', $result['errors']);

        } catch (\Exception $e) {
            return back()->withErrors(['xml_file' => $e->getMessage()]);
        }
    }
}
