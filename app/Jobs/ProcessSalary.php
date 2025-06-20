<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;

class ProcessSalary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ensure job runs only on the 15th of the month
        // if (Carbon::now()->day != 15) {
        //     return;
        // }

        // Get all branch staff and non-volunteer instructors
        $users = User::where('role', 'branch_staff') // Fetch branch staff
                    ->orWhere(function ($query) {
                        $query->where('role', 'instructor')
                              ->where('is_volunteer', false); // Non-volunteer instructors
                    })
                    ->get();

        foreach ($users as $user) {
            // Ensure salary is not already recorded for this month
            $existingSalary = Salary::where('user_id', $user->id)
                ->whereMonth('paid_date', Carbon::now()->month)
                ->whereYear('paid_date', Carbon::now()->year)
                ->first();

            if (!$existingSalary) {
                Salary::create([
                    'user_id' => $user->id,
                    'reference_no' => 'SAL-' . strtoupper(uniqid()),
                    'salary_status' => 'pending',
                    'paid_method' => null,
                    'paid_amount' => null,
                    'paid_date' => Carbon::now()->format('Y-m-d'), // 15th of the month
                    'notes' => 'Auto-generated salary record for ' . Carbon::now()->format('F Y'),
                ]);
            }
        }
        Log::debug("test");
    }
}
