<?php

namespace App\Http\Controllers;

use App\Models\InstructorAttendance;
use App\Models\KarateClassTemplate;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Instructor;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\InstructorAttendances;
use Illuminate\Http\Request;

class InstructorAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = InstructorAttendance::with(['instructor', 'schedule.karateClassTemplate', 'event']);

    // Filter by class or event
    if ($request->filled('filter_type') && $request->filled('filter_id')) {
        [$type, $id] = explode('_', $request->filter_id);

        if ($request->filter_type === 'class' && $type === 'class') {
            $query->whereHas('schedule', function ($q) use ($id) {
                $q->where('karate_class_template_id', $id);
            });
        }

        if ($request->filter_type === 'event' && $type === 'event') {
            $query->where('event_id', $id);
        }
    }

    // Filter by date range
    if ($request->filled('date_range')) {
        [$start, $end] = explode(' - ', $request->date_range);
        $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
    }

    $attendances = $query->latest()->get();
    $karateClassTemplates = KarateClassTemplate::all();
    

    $attendanceSummary = [
        'total' => $attendances->count(),
        'present' => $attendances->where('status', 'present')->count(),
        'absent' => $attendances->where('status', 'absent')->count(),
        'late' => $attendances->where('status', 'late')->count(),
    ];

    $byClass = $attendances->groupBy(fn($a) => optional($a->schedule?->karateClassTemplate)->class_name);
    $byEvent = $attendances->groupBy(fn($a) => optional($a->event)->title);

    return view('instructor_attendance.index', compact('attendances','karateClassTemplates', 'attendanceSummary', 'byClass', 'byEvent'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $karateClassTemplates = KarateClassTemplate::all();
   
    return view('instructor_attendance.create', compact('karateClassTemplates'));
}


    public function getSchedules($classId)
    {
        $schedules = Schedule::where('karate_class_template_id', $classId)->get(['id', 'schedule_date']);
        return response()->json(['schedules' => $schedules]);
    }

    public function getInstructors($scheduleId)
    {
       $schedule = Schedule::with('karateClassTemplate')->find($scheduleId);

        if (!$schedule) {
            return response()->json(['instructors' => []]);
        }

        $classTemplateId = $schedule->karate_class_template_id;

        $instructors = Instructor::with('user:id,name')
            ->get()
            ->map(function ($instructor) {
                return [
                    'id' => $instructor->user->id,
                    'name' => $instructor->user->name ?? 'Unnamed',
                ];
            });

        return response()->json(['instructors' => $instructors]);

    }



public function store(Request $request)
{
    $request->validate([
        'attendance' => 'required|array',
        'attendance.*' => 'in:present,absent,late',
    ]);

    $date = now()->format('Y-m-d');

    if ($request->filled('schedule_id')) {
        $schedule = Schedule::find($request->schedule_id);
        if ($schedule && $date < $schedule->date) {
            return back()->with('error', 'Attendance cannot be recorded before the scheduled class date.');
        }
    }

    foreach ($request->attendance as $instructorId => $status) {
        InstructorAttendance::updateOrCreate(
            [
                'instructor_id' => $instructorId,
                'schedule_id' => $request->schedule_id ?? null,
                'date' => $date,
            ],
            [
                'status' => $status,
                'recorded_by' => auth()->id(),
            ]
        );
    }

    return redirect()->route('instructor_attendance.index')->with('success', 'Attendance recorded successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(instructorAttendances $instructorAttendances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
public function edit($id)
{
    $attendance = InstructorAttendance::findOrFail($id);
    $instructors = Instructor::all();
    $karateClassTemplates = KarateClassTemplate::all();

    $schedules = $attendance->schedule_id
        ? Schedule::where('karate_class_template_id', $attendance->schedule->karate_class_template_id)->get()
        : collect();

    return view('instructor_attendance.edit', compact(
        'attendance',
        'instructors',
        'karateClassTemplates',
        'schedules'
    ));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
            'date' => 'required|date',
        ]);

        $attendance = InstructorAttendance::findOrFail($id);
        $attendance->update([
            'status' => $request->status,
            'date' => $request->date,
        ]);

        return redirect()->route('instructor_attendance.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        $instructor_attendance = InstructorAttendance::findOrFail($id);
        $instructor_attendance->delete();

        return redirect()->route('instructor_attendance.index')->with('success', 'Attendance record deleted.');
    }
    
}
