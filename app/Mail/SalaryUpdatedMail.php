<?php

namespace App\Mail;

use App\Models\Salary;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalaryUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $salary;

    public function __construct(Salary $salary)
    {
        $this->salary = $salary;
    }

    public function build()
    {
        return $this->subject('Salary Payment Confirmation')
                    ->view('emails.salary_updated');
    }
}
