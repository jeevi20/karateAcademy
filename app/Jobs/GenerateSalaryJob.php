<?php

namespace App\Jobs;

use App\Models\Salary;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateSalaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        $salaryMonth = Carbon::now()->format('Y-m'); // "2025-03"

        // Fetch branch staff
        $branchStaff = User::whereHas('role', function ($query) {
            $query->where('role_name', 'branchstaff');
        })->get();

        // Fetch paid instructors
        $paidInstructors = Instructor::where('is_volunteer', false)->get();

        // Merge branch staff & instructors  
        $paidStaff = $branchStaff->merge($paidInstructors);

        foreach ($paidStaff as $staff) {
            $salaryAmount = ($staff instanceof User) ? 10000 : 25000; // 10K for branch staff, 25K for instructors

            $referenceNo = 'SAL-' . strtoupper(Str::random(8)) . '-' . $salaryMonth;

            // Check if salary already exists for this month
            $existingSalary = Salary::where('user_id', $staff->id)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->first();

            if (!$existingSalary) {
                Salary::create([
                    'user_id'       => $staff->id,
                    'reference_no'  => $referenceNo,
                    'salary_status' => 'pending',
                    'paid_amount'   => $salaryAmount,
                    'paid_method'   => null,
                    'paid_date'     => null,
                    'notes'         => "Salary scheduled for {$salaryMonth}.",
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
