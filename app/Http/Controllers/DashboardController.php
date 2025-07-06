<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //Counts
        $instructorCount   = User::where('role_id', 3)->count();
        $branchStaffCount  = User::where('role_id', 2)->count();
        $studentCount      = User::where('role_id', 4)->count();
        $branchCount       = Branch::count();
        $eventCount        = Event::count();

        //Load recent users
        $recentUsers = User::latest()->take(5)->get();
        $today       = Carbon::today();

        //Fetch today's schedules, group by branch name
        $schedulesToday = Schedule::with(['karateClassTemplate', 'instructor', 'branch'])
            ->whereDate('schedule_date', $today)
            ->get()
            ->groupBy(fn($s) => $s->branch->branch_name);
        // Using Collection::groupBy *after* get() ensures branch-name-keyed structure for Blade loops 
        // :contentReference[oaicite:1]{index=1}

        //Events and announcements
        $upcomingEvents = Event::where('event_date', '>', $today)
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $announcements = Announcement::orderBy('announcement_date', 'desc')
            ->take(5)
            ->get();

        //Monthly enrollment data per branch
        $year           = now()->year;
        $branches       = Branch::all();
        $monthLabels    = collect(range(1,12))
            ->map(fn($m) => Carbon::createFromDate(null, $m, 1)->format('M'))
            ->toArray();

        $studentData = User::where('role_id', 4)
            ->join('students', 'users.id', '=', 'students.user_id')
            ->whereYear('students.enrollment_date', $year)
            ->selectRaw('users.branch_id, MONTH(students.enrollment_date) as month, COUNT(*) as count')
            ->groupBy('users.branch_id', 'month')
            ->get();

        $studentsByBranch = [];
        foreach ($branches as $branch) {
            $studentsByBranch[$branch->branch_name] = array_fill(0, 12, 0);
        }
        foreach ($studentData as $rec) {
            $name       = $branches->firstWhere('id', $rec->branch_id)->branch_name ?? 'Unknown';
            $studentsByBranch[$name][$rec->month - 1] = $rec->count;
        }

        //Monthly revenue 
        $monthlyRevenue = array_fill(0, 12, 0);
        $revenueData = Payment::selectRaw('MONTH(date_paid) as month, SUM(amount) as total')
            ->whereYear('date_paid', $year)
            ->groupBy('month')
            ->get();
        foreach ($revenueData as $rec) {
            $monthlyRevenue[$rec->month - 1] = $rec->total;
        }

        // Prepare data arrays for charts
        $studentEnrollments = [
            'labels'   => $monthLabels,
            'branches' => $studentsByBranch,
        ];

        return view('dashboard', compact(
            'announcements',
            'instructorCount',
            'branchStaffCount',
            'studentCount',
            'branchCount',
            'eventCount',
            'recentUsers',
            'schedulesToday',
            'upcomingEvents',
            'studentEnrollments',
            'monthlyRevenue'
        ));
    }
}
