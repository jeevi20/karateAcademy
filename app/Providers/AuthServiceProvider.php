<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Payment;
use App\Models\Event;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        

        Gate::define('download-admission-card', function ($user, Payment $payment) {
                //  loggedin user is the existing student (student_id)
                return $user->id === $payment->student_id
                && $student->admission_granted //have been granted admission
                && $payment->event->is_admission_released; //admin has released the cards
        });

         Gate::define('is-admin', function ($user) {
        return $user->role_id === 1;
        });
        Gate::define('is-branch-staff', function ($user) {
        return $user->role_id === 2;
        });
        Gate::define('is-instructor', function ($user) {
        return $user->role_id === 3;
        });
        Gate::define('is-student', function ($user) {
        return $user->role_id === 4;
        });
    }
}
