<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('salary:generate')->everyMinute();
    //     $schedule->command('schedule:generate')->monthlyOn(12, '11:12'); // Runs on the 1st of every month
    //     $schedule->command('schedule:generate')->everyMinute();
    // }
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new \App\Jobs\GenerateSchedulesJob)->daily();
    }


    
    //role based access
    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];

    protected $commands = [
        \App\Console\Commands\ScheduleGenerate::class,
    ];
    


    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
