<?php


namespace App\Http\Controllers;

use App\Models\KarateClassTemplate;
use App\Models\Schedule;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class KarateClassTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch class templates with branch, instructor, and schedules
        $karateClasses = KarateClassTemplate::with('branch', 'instructor', 'schedules')->get();

        // Fetch only users with role_id 3 (Instructors)
        $instructors = User::where('role_id', 3)->get();

        // Calculate totals
        $totalClasses = $karateClasses->count();
        $totalSchedules = Schedule::count();

        return view('class_template.index', compact('karateClasses', 'totalClasses', 'totalSchedules', 'instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch branches and instructors
        $branches = Branch::all();
        $instructors = User::where('role_id', 3)->get();

        return view('class_template.create', compact('branches', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'class_name' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Create the class template
        KarateClassTemplate::create([
            'class_name' => $request->class_name,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('class_template.index')->with('success', 'Class Template created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KarateClassTemplate $karateClassTemplate)
    {
        $branches = Branch::all();
        $instructors = User::where('role_id', 3)->get();

        return view('class_template.edit', compact('karateClassTemplate', 'branches', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KarateClassTemplate $karateClassTemplate)
    {
        $request->validate([
        'class_name' => 'required|string|max:255',
        'day' => 'required|string|max:255',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $karateClassTemplate->update($request->all());

        return redirect()->route('class_template.index')->with('success', 'Class Template updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $karateClassTemplate = karateClassTemplate::findOrFail($id);
        $karateClassTemplate->delete();
        return redirect()->route('class_template.index')->with('success', 'Schedule moved to trash successfully.');
    }

}
