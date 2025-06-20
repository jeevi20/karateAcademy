<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $announcements = Announcement::orderBy('announcement_date', 'desc')->take(5)->get();
        return view('dashboard', compact('announcements'));
    }
}