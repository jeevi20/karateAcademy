<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Trash;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the 3 latest announcements for the dashboard
        $announcements = Announcement::latest()->take(3)->get();

        return view('announcement.index', compact('announcements'));
    }

    // Get the older announcements
    
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'announcement_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_active' => 'boolean',
            'audience' => 'required|in:all,branchstaff,instructors,students',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }

        $data['created_by'] = auth()->id();

        Announcement::create($data);

        return redirect()->route('announcement.index')->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.edit', compact('announcement'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'announcement_date' => 'required|date',
            'audience' => 'required|in:all,branchstaff,instructors,students',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the existing announcement
        $announcement = Announcement::findOrFail($id);

        // Prepare update data
        $updateData = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'announcement_date' => $request->input('announcement_date'),
            'audience' => $request->input('audience'),
        ];

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image) {
                Storage::delete('public/' . $announcement->image);
            }
            // Store new image
            $updateData['image'] = $request->file('image')->store('announcements', 'public');
        }

        // Update the announcement
        $announcement->update($updateData);

        return redirect()->route('announcement.index')->with('success', 'Announcement updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->delete();

        return redirect()->route('announcement.index')->with('success', 'Announcement record moved to trash successfully.');
    }
}
