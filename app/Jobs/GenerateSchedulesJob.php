<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\KarateClassTemplate;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateSchedulesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $today = now()->toDateString();
        $dayOfWeek = now()->format('l'); // Get today's day name (Monday, Tuesday, etc.)

        $classTemplates = KarateClassTemplate::where('day', $dayOfWeek)->get();

        foreach ($classTemplates as $template) {
            Schedule::updateOrCreate(
                [
                    'karate_class_template_id' => $template->id,
                    'schedule_date' => $today,
                ],
                [
                    'instructor_id' => $template->instructor_id ?? null,
                    'status' => 'scheduled',
                ]
            );
        }
    }
}
