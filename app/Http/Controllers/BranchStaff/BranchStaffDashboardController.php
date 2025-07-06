<?php

namespace App\Http\Controllers\BranchStaff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\User;
use App\Models\Payment;
use App\Models\Announcement;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Event;
use App\Models\StudentAttendance;

class BranchStaffDashboardController extends Controller
{
   
    public function index()
{
    $user = Auth::user();

    $branch = $user->branch; 



    if (!$branch) {
        return view('branchstaff_dashboard')->with('error', 'Branch not found.');
    }

    $students = User::where('branch_id', $branch->id)
                    ->where('role_id', 4)
                    ->get();

    $studentIds = $students->pluck('id');

    $payments = Payment::whereIn('student_id', $studentIds)->get();

    $announcements = Announcement::orderBy('announcement_date', 'desc')->take(5)->get();

    $today = Carbon::today();
    $today = Carbon::today();

    $schedulesToday = Schedule::with(['karateClassTemplate', 'instructor', 'branch'])
        ->whereDate('schedule_date', $today)
        ->get();

    $upcomingEvents = Event::where('event_date', '>', Carbon::today())
        ->orderBy('event_date')
        ->take(5)
        ->get();


    $branchId = $user->branch->id; 

    $attendanceToday = StudentAttendance::whereDate('date', Carbon::today())
    ->whereHas('student', function ($q) use ($branchId) {
        $q->where('branch_id', $branchId);
    })->get()->groupBy('status');

    $attendance = [
    'present' => $attendanceToday->get('present')?->count() ?? 0,
    'absent' => $attendanceToday->get('absent')?->count() ?? 0,
    'late' => $attendanceToday->get('late')?->count() ?? 0,
];
    $instructors = User::where('branch_id', $branch->id)
                    ->where('role_id', 3)
                    ->get();


    return view('branchstaff_dashboard', compact('branch', 'students', 'payments', 'announcements','schedulesToday','upcomingEvents','attendanceToday',
'attendance','instructors'));
}




}
