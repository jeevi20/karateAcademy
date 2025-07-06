<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SalaryUpdatedMail;
use Illuminate\Support\Facades\Mail;


class SalaryController extends Controller
{
    public function index()
    {
        $this->generateMonthlySalaries(); 

        $salaries = Salary::latest()->get();
        return view('salary.index', compact('salaries'));
    }

    protected function generateMonthlySalaries()
    {
        $today = Carbon::today();

        // Only generate on 4th day of the month
        if ($today->day != 4) return;

        // Avoid duplicate generation
        $alreadyGenerated = Salary::whereYear('created_at', $today->year)
            ->whereMonth('created_at', $today->month)
            ->exists();

        if ($alreadyGenerated) return;

        $instructors = Instructor::where('is_volunteer', false)->get();
        $branchStaff = User::where('role_id', 2)->get();

        foreach ($instructors as $instructor) {
            Salary::create([
                'instructor_id' => $instructor->id,
                'created_by' => auth()->id() ?? 1,
                'paid_date' => $today,
                'reference_no' => 'SAL-IN-' . strtoupper(uniqid()),
                'salary_status' => 'pending',
                'notes' => 'instructor:' . $instructor->id,
            ]);
        }

        foreach ($branchStaff as $staff) {
            Salary::create([
                'instructor_id' => null,
                'created_by' => auth()->id() ?? 1,
                'paid_date' => $today,
                'reference_no' => 'SAL-BRA-' . strtoupper(uniqid()),
                'salary_status' => 'pending',
                'notes' => 'branch_staff:' . $staff->id,
            ]);
        }
    }

    // OPTIONAL: only needed if using a dedicated edit page
    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        return view('salary.edit', compact('salary'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'paid_amount' => 'required|numeric|min:0',
        'paid_method' => 'required|string|max:255',
        'notes' => 'nullable|string',
    ]);

    $salary = Salary::findOrFail($id);

    $salary->paid_amount = $request->paid_amount;
    $salary->paid_method = $request->paid_method;
    $salary->salary_status = 'paid';
    $salary->paid_date = now();

    if ($request->filled('notes')) {
        $salary->notes .= ' | ' . $request->notes;
    }

    $salary->save();

    // Extract user ID based
    if (preg_match('/(instructor|branch_staff):(\d+)/', $salary->notes, $matches)) {
        $type = $matches[1];
        $id = (int) $matches[2];

        if ($type === 'instructor') {
            $instructor = \App\Models\Instructor::find($id);
            $user = $instructor?->user; 
        } else {
            $user = \App\Models\User::find($id);
        }

        if ($user && $user->email) {
            \Mail::to($user->email)->send(new \App\Mail\SalaryUpdatedMail($salary));
        } else {
            \Log::warning("Email not sent — Missing email or user for salary ID {$salary->id}");
        }
    }


    return redirect()->route('salary.index')->with('success', 'Salary updated and email sent successfully.');
}





}
