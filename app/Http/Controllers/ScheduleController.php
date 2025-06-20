<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Branch;
use App\Models\KarateClassTemplate;
use App\Notifications\ClassScheduledNotification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with('karateClassTemplate');

        if ($request->has('karate_class_template_id')) { 
            $query->where('karate_class_template_id', $request->karate_class_template_id);
        }

        $instructors = User::where('role_id', 3)->get();
        $branches = Branch::all();
        $schedules = $query->get();

        return view('schedule.index', compact('schedules', 'instructors',));
    }

    /**
     * Show the form for creating a new resource.
     */
    

    public function create(Request $request)
    {
        $karateClassTemplates = KarateClassTemplate::with('branch')->get(); 
        $instructors = User::where('role_id', 3)->get();
        $branches = Branch::all();

        // Check if the 'weekend' parameter exists in the query string and is set to 'weekend'
        $isWeekend = $request->has('weekend') && strtolower($request->weekend) == 'weekend';

        return view('schedule.create', compact('karateClassTemplates', 'instructors', 'branches', 'isWeekend'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'karate_class_template_id' => 'required|exists:karate_class_templates,id',
            'branch_id' => 'required|exists:branches,id',
            'instructor_id' => 'nullable|exists:users,id',
            'schedule_date' => 'required|date',
            'instructor_id' => 'nullable',

        ]);

        
        $schedule = Schedule::create([
            'karate_class_template_id' => $request->karate_class_template_id,
            'schedule_date' => $request->schedule_date,
            'status' => 'scheduled',
            'instructor_id' => $request->instructor_id ?? null,
            'branch_id' => $request->branch_id,
        ]);


        return redirect()->route('schedule.index')->with('success', 'Schedule created successfully ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $karateClassTemplates = KarateClassTemplate::with('branch')->get();
        $instructors = User::where('role_id', 3)->get();
        $branches = Branch::all();

        return view('schedule.edit', compact('schedule', 'karateClassTemplates', 'instructors', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'karate_class_template_id' => 'required|exists:karate_class_templates,id',
            'instructor_id' => 'nullable|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'schedule_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,canceled',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update([
            'karate_class_template_id' => $request->karate_class_template_id,
            'schedule_date' => $request->schedule_date,
            'status' => $request->status,
            'instructor_id' => $request->instructor_id ?? null,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Schedule moved to trash successfully.');
    }
}
