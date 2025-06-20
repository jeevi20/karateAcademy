<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GenerateSalaryJob;

class GenerateSalarySchedule extends Command
{
    protected $signature = 'salary:generate';
    protected $description = 'Generate monthly salary schedule using a queue job';

    public function handle()
    {
        GenerateSalaryJob::dispatch(); 
        $this->info('Salary generation job dispatched.');
    }
}
