<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Announcement;
use App\Models\Trash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate input data
    $request->validate([
        'title' => 'required|string|max:255',
        'event_type' => 'required|in:tournament,seminar,grading exams,other',
        'event_date' => 'required|date', 
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time', // Validate as time format
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Combine event date and time for start and end time
    $startDateTime = $request->input('event_date') . ' ' . $request->input('start_time') . ':00'; 
    $endDateTime = $request->input('end_time') ? ($request->input('event_date') . ' ' . $request->input('end_time') . ':00') : null;

    // Create event
    $event = Event::create([
        'title' => $request->input('title'),
        'event_type' => $request->input('event_type'),
        'event_date' => $request->input('event_date'),
        'start_time' => $startDateTime, // Store the full start time
        'end_time' => $endDateTime,     // Store the full end time if available
        'location' => $request->input('location'),
        'description' => $request->input('description', 'N/A'),
        'created_by' => Auth::id(),
    ]);

    // Call the function to publish the payment announcement
    $this->publishPaymentAnnouncement($event);

    return redirect()->route('event.index')->with('success', 'Event created and payment announcement published.');
}

protected function publishPaymentAnnouncement($event)
{
    // Create the payment announcement
    Announcement::create([
        'title' => 'Payment Announcement for ' . $event->title,
        'body' => 'Payment for the event "' . $event->title . '" is now open. Please make your payment.',
        'announcement_date' => Carbon::now(),
        'audience' => 'all',
        'is_active' => true,
        'created_by' => Auth::id(),
    ]);
}




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validate input data
    $request->validate([
        'title' => 'required|string|max:255',
        'event_type' => 'required|in:tournament,seminar,grading exams,other',
        'event_date' => 'required|date', 
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time', 
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    $event = Event::findOrFail($id);

    // Combine event date and time for start and end time
    $startDateTime = $request->input('event_date') . ' ' . $request->input('start_time') . ':00'; 
    $endDateTime = $request->input('end_time') ? ($request->input('event_date') . ' ' . $request->input('end_time') . ':00') : null;

    // Update event details
    $event->update([
        'title' => $request->input('title'),
        'event_type' => $request->input('event_type'),
        'event_date' => $request->input('event_date'),
        'start_time' => $startDateTime,
        'end_time' => $endDateTime,
        'location' => $request->input('location'),
        'description' => $request->input('description', 'N/A'),
    ]);

    return redirect()->route('event.index')->with('success', 'Event updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return redirect()->route('event.index')->with('success', 'Event record moved to trash successfully.');
    }


    /**
     *  Update event status.
     */
    
     public function updateStatus(Request $request, $id)
     {
         $event = Event::findOrFail($id);
         
         // Only the "cancelled" status is allowed
         if ($request->status === 'cancelled') {
             $event->status = 'cancelled';
             $event->save();
 
             return redirect()->route('event.index')->with('success', 'Event status updated to cancelled');
         }
 
         return redirect()->route('event.index')->with('error', 'Invalid status');
     }
}