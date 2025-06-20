<?php

namespace App\Http\Controllers;

use App\Models\KarateClassTemplate;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $classes = KarateClassTemplate::with(['branch', 'instructor', 'schedules'])->get();
        $totalClasses = $classes->count();
        $totalSchedules = Schedule::count();
        $instructors = User::where('role_id', 3)->get();
        return view('class.index', compact('classes', 'totalClasses', 'totalSchedules','instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
