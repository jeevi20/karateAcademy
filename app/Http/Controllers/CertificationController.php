<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use App\Models\Student;
use App\Models\Certification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certifications = Certification::with('user')->latest()->get();
        return view('certification.index', compact('certifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role_id', 4)->get(); 
        return view('certification.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'certification_type' => 'required|in:tournement,seminar,grading,belt',
        'issued_date' => 'required|date',
    ]);

    // Create certification
    $certification = Certification::create([
        'user_id' => $request->user_id,
        'certification_type' => $request->certification_type,
        'issued_date' => $request->issued_date,
    ]);

    // Map certification_type to achievement_type
    $achievementTypeMap = [
        'tournement' => 'certificate',
        'seminar' => 'certificate',
        'grading' => 'academy_belt',
        'belt' => 'past_belt',
    ];

    $achievementType = $achievementTypeMap[$request->certification_type] ?? 'certificate';

    // Get student ID from user_id
    $student = \App\Models\Student::where('user_id', $request->user_id)->first();

    if ($student) {
        \App\Models\Achievement::create([
            'student_id' => $student->id,
            'achievement_type' => $achievementType,
            'achievement_name' => ucfirst($request->certification_type) . ' Certificate',
            'achievement_date' => $request->issued_date,
            'organization_name' => 'Japanese Shotokan Karate International',
            'remarks' => 'Automatically added from certification',
        ]);
    }

    return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
}



    public function download(Certification $certification)
    {
        $pdf = Pdf::loadView('certification.template', compact('certification'));
        return $pdf->download('certificate_'.$certification->id.'.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certification $certification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        //
    }
}
