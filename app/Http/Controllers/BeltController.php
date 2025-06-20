<?php

namespace App\Http\Controllers;

use App\Models\Belt;
use Illuminate\Http\Request;

class BeltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $belts = Belt::all();
        return view('belt.index' , compact('belts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $belt = Belt::findOrFail($id);
        return view('belt.show', compact('belt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $belt = Belt::findOrFail($id);
        return view('belt.edit', compact('belt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rank' => 'required|string',
            'color' => 'required|string',
            'requirements' => 'required|string|max:255',
            'max_attempts' => 'required|string',
        ]);

        // Fetch belt by ID
        $belt = Belt::findOrFail($id);

        // Update belt details
        $belt->update([
            'name' => $request->input('name'), 
            'rank' => $request->input('rank'),
            'color' => $request->input('color'),
            'requirements' => $request->input('requirements'),
            'max_attempts' => $request->input('max_attempts'),
        ]);

        // Redirect back to another page with success message
        return redirect()->route('belt.index')->with('success', 'Belt updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(belts $belts)
    {
        //
    }
}
