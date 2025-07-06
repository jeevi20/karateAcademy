<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Models\KarateClassTemplate;
use App\Models\Schedule;
use App\Models\Event;
use App\Models\User;
use App\Models\Branch;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StudentAttendanceController extends Controller
{
    public function index()
{
    
    $attendances = StudentAttendance::with(['student', 'schedule.karateClassTemplate', 'event'])->latest()->get();
    $karateClassTemplates = KarateClassTemplate::all();
    $events = Event::all();

    $attendanceSummary = [
        'total' => $attendances->count(),
        'present' => $attendances->where('status', 'present')->count(),
        'absent' => $attendances->where('status', 'absent')->count(),
        'late' => $attendances->where('status', 'late')->count(),
    ];

    // Grouped by class name
    $byClass = $attendances->groupBy(fn($a) => optional($a->schedule?->karateClassTemplate)->class_name);

    // Grouped by event name
    $byEvent = $attendances->groupBy(fn($a) => optional($a->event)->title);

    return view('student_attendance.index', compact('attendances','karateClassTemplates','events', 'attendanceSummary', 'byClass', 'byEvent'));
}


    public function create()
    {
        $karateClassTemplates = KarateClassTemplate::all();
        $events = Event::all(); 

        return view('student_attendance.create', compact('karateClassTemplates', 'events'));
    }

    public function getSchedules($classId)
    {
        $schedules = Schedule::where('karate_class_template_id', $classId)->get();
        return response()->json(['schedules' => $schedules]);
    }

    public function getStudents($scheduleId)
    {
        $schedule = Schedule::with('karateClassTemplate')->find($scheduleId);

        if (!$schedule) {
            return response()->json(['students' => []]);
        }

        $classTemplateId = $schedule->karate_class_template_id;

        $students = Student::where('karate_class_template_id', $classTemplateId)
            ->with('user:id,name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->user->id,
                    'name' => $student->user->name ?? 'Unnamed',
                ];
            });

        return response()->json(['students' => $students]);
    }

    public function getRegisteredStudentsForEvent($eventId)
    {
        $students = Student::whereHas('gradingExamAdmissions', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })
        ->with('user:id,name')
        ->get()
        ->map(function ($student) {
            return [
                'id' => $student->user->id,
                'name' => $student->user->name ?? 'Unnamed',
            ];
        });

        return response()->json(['students' => $students]);
    }

    public function getAllStudentsForEvent($eventId)
    {
        $students = Student::with('user:id,name')->get()
            ->map(function ($student) {
                return [
                    'id' => $student->user->id,
                    'name' => $student->user->name ?? 'Unnamed',
                ];
            });

        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late',
        ]);

        $date = now()->format('Y-m-d');

        // Check if a schedule is selected
        if ($request->filled('schedule_id')) {
            $schedule = Schedule::find($request->schedule_id);
            if ($schedule && $date < $schedule->date) {
                return back()->with('error', 'Attendance cannot be recorded before the scheduled class date.');
            }
        }

        // Check if an event is selected
        if ($request->filled('event_id')) {
            $event = Event::find($request->event_id);
            if ($event && $date < $event->date) {
                return back()->with('error', 'Attendance cannot be recorded before the event date.');
            }
        }

        foreach ($request->attendance as $studentId => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'schedule_id' => $request->schedule_id ?? null,
                    'event_id' => $request->event_id ?? null,
                    'date' => $date,
                ],
                [
                    'status' => $status,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('student_attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function download(Request $request)
{
    $filterIdRaw = $request->filter_id;
    $format = $request->format;

    if (!$filterIdRaw || !$format) {
        return redirect()->back()->with('error', 'Filter or format missing.');
    }

    [$type, $id] = explode('_', $filterIdRaw);
    $query = StudentAttendance::with(['student', 'schedule.karateClassTemplate', 'event']);

    if ($type === 'class') {
        $query->whereHas('schedule', fn($q) => $q->where('karate_class_template_id', $id));
    } elseif ($type === 'event') {
        $query->where('event_id', $id);
    }

    $attendances = $query->get();
    $fileName = 'student_attendance_' . now()->format('Ymd_His');

    if ($format === 'excel' || $format === 'csv') {
        return Excel::download(new StudentAttendanceExport($attendances), $fileName . '.' . ($format === 'excel' ? 'xlsx' : 'csv'));
    }

    if ($format === 'pdf') {
        $pdf = PDF::loadView('exports.attendance_pdf', compact('attendances'));
        return $pdf->download($fileName . '.pdf');
    }

    return redirect()->back()->with('error', 'Unsupported format');
}

public function edit($id)
{
    $attendance = StudentAttendance::findOrFail($id);
    $students = User::where('role_id', 4)->get(); 
    $karateClassTemplates = KarateClassTemplate::all();
    $events = Event::all(); 

    
    $attendanceType = $attendance->schedule_id ? 'class' : 'event';

    $schedules = $attendanceType === 'class'
        ? Schedule::where('karate_class_template_id', $attendance->schedule->karate_class_template_id)->get(): collect();

    return view('student_attendance.edit', compact('attendance', 'students', 'attendanceType' , 'events', 'karateClassTemplates', 'schedules'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:present,absent,late',
        'date' => 'required|date',
    ]);

    $attendance = StudentAttendance::findOrFail($id);
    $attendance->update([
        'status' => $request->status,
        'date' => $request->date,
    ]);

    return redirect()->route('student_attendance.index')->with('success', 'Attendance updated successfully.');
}


public function destroy($id)
{
    $student_attendance = StudentAttendance::findOrFail($id);
    $student_attendance->delete();

    return redirect()->route('student_attendance.index')->with('success', 'Attendance record deleted.');
}

public function studentMonthlyReport(Request $request)
{
    $branches = Branch::all();
    $classes = KarateClassTemplate::all();
    $students = User::where('role_id', 4)->get();
    
    


    if ($request->filled('branch_id')) {
    $query->whereHas('student', fn($q) =>
        $q->where('branch_id', $request->branch_id)
    );
    }
    $query = StudentAttendance::with(['student.branch', 'schedule.karateClassTemplate']);


    if ($request->filled('branch_id')) {
        $query->whereHas('student.user', fn($q) =>
            $q->where('branch_id', $request->branch_id)
        );
    }

    if ($request->filled('class_id')) {
        $query->whereHas('schedule', fn($q) =>
            $q->where('karate_class_template_id', $request->class_id)
        );
    }

    if ($request->filled('student_id')) {
        $query->where('student_id', $request->student_id);
    }

    if ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $query->whereMonth('date', $month->month)
              ->whereYear('date', $month->year);
    }

    $attendances = $query->get();

    $summary = $attendances->groupBy('student_id')->map(function ($records) {
        $total = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent = $records->where('status', 'absent')->count();
        $late = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        return [
            
            'student' => $records->first()->student->name ?? '',
            'total' => $total,
            
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'percentage' => $percentage,
        ];
    });

    return view('student_attendance.monthly_report', compact('summary', 'attendances', 'request','branches', 'classes', 'students', ));
}

public function studentMonthlyReportPrint(Request $request)
{
    $branches = Branch::all();
    $classes = KarateClassTemplate::all();
    $students = User::where('role_id', 4)->get();

    // Parse the month from request or set null
    if ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $formattedMonth = $month->format('F Y');
    } else {
        $month = null;
        $formattedMonth = 'All Months';
    }


    $query = StudentAttendance::with(['student.branch', 'schedule.karateClassTemplate']);

    if ($request->filled('branch_id')) {
        $query->whereHas('student.user', fn($q) =>
            $q->where('branch_id', $request->branch_id)
        );
    }

    if ($request->filled('class_id')) {
        $query->whereHas('schedule', fn($q) =>
            $q->where('karate_class_template_id', $request->class_id)
        );
    }

    if ($request->filled('student_id')) {
        $query->where('student_id', $request->student_id);
    }

    if ($month) {
        $query->whereMonth('date', $month->month)
              ->whereYear('date', $month->year);
    }

    $attendances = $query->get();

    $summary = $attendances->groupBy('student_id')->map(function ($records) use ($month) {
        $total = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent = $records->where('status', 'absent')->count();
        $late = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        return [
            'student' => $records->first()->student->name ?? '',
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'percentage' => $percentage,
        ];
    });

    return view('student_attendance.monthly_report_print', compact('summary', 'attendances', 'request', 'branches', 'classes', 'students', 'formattedMonth'));
}



}
