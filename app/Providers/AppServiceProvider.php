<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View; 
use App\Models\Branch;
use App\Models\Announcement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (Schema::hasTable('branches')) {
            View::share('branchCount', Branch::count());
        }


         View::composer('layouts.admin.master', function ($view) {
        $user = Auth::user();

        if ($user) {
            $roleAudienceMap = [
                'admin' => ['all', 'branchstaff', 'instructors', 'students', 'admin'], 
                'branchstaff' => ['all', 'branchstaff'],
                'instructor' => ['all', 'instructors'],
                'student' => ['all', 'students'],
            ];

            $roleName = strtolower($user->role->name);

            $audiences = $roleAudienceMap[$roleName] ?? ['all'];

            $announcements = Announcement::whereIn('audience', $audiences)
                ->orderBy('announcement_date', 'desc')
                ->limit(5)
                ->get();

            $view->with('announcements', $announcements);
        } else {
            $view->with('announcements', collect());
        }
    });
    }


    
}
