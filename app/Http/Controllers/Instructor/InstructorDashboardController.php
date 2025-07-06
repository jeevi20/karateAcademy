<?php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\User;
use App\Models\StudentAttendance;
use App\Models\Event;
use App\Models\Announcement;
use Carbon\Carbon;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();

        // Today's date
        $today = Carbon::today();

        // Get today's schedules assigned to the instructor
        $todaySchedules = Schedule::with('karateClassTemplate')
            ->where('instructor_id', $instructor->id)
            ->whereDate('schedule_date', $today)
            
            ->get();


        // Upcoming events (future events only)
        $upcomingEvents = Event::whereDate('event_date', '>', $today)
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // General announcements from admin
        $announcements = Announcement::where('audience', 'instructor')
            ->orWhereNull('audience')
            ->latest()
            ->take(5)
            ->get();

        return view('instructor_dashboard', compact(
            'todaySchedules',
            
            'upcomingEvents',
            'announcements'
        ));
    }
}






