<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\Event;
use App\Models\Schedule;

use App\Models\Achievement;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['students', 'instructors'])->get();
        return view('branch.index', compact('branches'));
    }

    public function create()
    {
        return view('branch.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string',
            'email' => 'required|email',
            'phone_no' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
        ]);

        Branch::create($validated);

        return redirect()->route('branch.index')->with('success', 'Branch created successfully!');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branch.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string',
            'email' => 'required|email',
            'phone_no' => [
                    'required',
                    'string',
                    'regex:/^(?:0|\+94)(?:7\d{8}|1\d{8}|2\d{8}|3\d{8}|4\d{8}|5\d{8}|6\d{8}|8\d{8}|9\d{8})$/'
                ],

        ]);

        $branch = Branch::findOrFail($id);
        $branch->update($validated);

        return redirect()->route('branch.show', $branch->id)->with('success', 'Branch details updated successfully!');
    }

    public function show($id)
    {
        $branch = Branch::with(['students', 'instructors'])->findOrFail($id);
        return view('branch.show', compact('branch'));
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branch.index')->with('success', 'Branch record moved to trash successfully!');
    }

    public function generateReport($branchId)
    {
        $branch = Branch::findOrFail($branchId);

        $staff = User::where('role_id', 2)->where('branch_id', $branchId)->get();

        $students = User::where('role_id', 4)->where('branch_id', $branchId)->get();

        $classes = Schedule::where('branch_id', $branchId)->get();

        // Events that have students belonging to the branch
        $events = Event::whereHas('students', function ($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();

        // Students who participated in any event of the branch
        $studentsInEvents = User::where('branch_id', $branchId)
            ->whereHas('events')
            ->get();

        // Grading exams that have students belonging to the branch
        $gradingExams = Event::where('event_type', 'grading_exam')
            ->whereHas('students', function ($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();


        // Students who participated in any grading exam of the branch
        $studentsInGradingExams = User::where('branch_id', $branchId)
    ->whereHas('events', function ($q) {
        $q->where('event_type', 'grading_exam');
    })
    ->get();


        $achievements = Achievement::whereHas('student.user', function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->get();


        $payments = Payment::whereHas('student', function ($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->get();

        $data = compact(
            'branch',
            'staff',
            'students',
            'classes',
            'events',
            'studentsInEvents',
            'gradingExams',
            'studentsInGradingExams',
            'achievements',
            'payments'
        );

        $pdf = Pdf::loadView('branch.report', $data);

        return $pdf->download("Branch_Report_{$branch->branch_name}.pdf");
    }
}

