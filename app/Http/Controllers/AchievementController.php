<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use App\Models\Student;
use App\Models\Belt;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $achievements = Achievement::with('student')
            ->when($query, function ($q) use ($query) {
                $q->where('achievement_name', 'LIKE', "%{$query}%")
                ->orWhere('achievement_type', 'LIKE', "%{$query}%")
                ->orWhereHas('student', function ($subQuery) use ($query) {
                    $subQuery->where('student_reg_no', 'LIKE', "%{$query}%");
                });
            })
            ->get();

        return view('achievement.index', compact('achievements', 'query'));
    }


   
    public function create($studentId)
{
    $student = Student::with('user')->findOrFail($studentId);
    $belts = Belt::all();

    return view('achievement.create', compact('student', 'belts'));
}




    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'achievement_type' => 'required|in:past_belt,academy_belt,medal,certificate,awards',
            'achievement_name' => 'required|string|max:255',
            'achievement_date' =>  'required|date|before_or_equal:today',
            'organization_name' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        Achievement::create([
            'student_id' => $request->student_id,
            'achievement_type' => $request->achievement_type,
            'achievement_name' => $request->achievement_name,
            'achievement_date' => $request->achievement_date,
            'organization_name' => $request->organization_name,
            'remarks' => $request->remarks,
            'belt_id' => $request->belt_id, 
        ]);
        

        return redirect()->route('achievement.show', $request->student_id)->with('success', 'Achievement added successfully!');

    }

    public function show($studentId)
    {
        $student = Student::with('user')->findOrFail($studentId); 
        $achievements = $student->achievements()->latest()->get(); 
    
        return view('achievement.show', compact('student', 'achievements'));  
    }


    public function edit($studentId, $achievementId)
    {
        
        $student = Student::with('user')->findOrFail($studentId);

        $achievement = Achievement::findOrFail($achievementId);

        $belts = Belt::all();

        return view('achievement.edit', compact('student', 'achievement', 'belts'));
    }



    

    public function update(Request $request, $id)
    {
        $request->validate([
            'achievement_type' => 'required|in:past_belt,academy_belt,medal,certificate,awards',
            'achievement_name' => 'required|string|max:255',
            'achievement_date' =>  'required|date|before_or_equal:today',
            'organization_name' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $achievement = Achievement::findOrFail($id);
        $achievement->update($request->all());

        return redirect()->route('achievement.index')->with('success', 'Achievement updated successfully!');
    }

    public function destroy($id)
{
    $achievement = Achievement::findOrFail($id);
    $studentId = $achievement->student_id;

    $achievement->delete(); 

    $remainingAchievements = Achievement::where('student_id', $studentId)->count();

    if ($remainingAchievements === 0) {
        return redirect()->route('achievement.index', ['search' => $studentId])
            ->with('success', "Achievement deleted successfully! No achievements remain for this student.");
    }

    return redirect()->route('achievement.index', ['search' => $studentId])
        ->with('success', 'Achievement deleted successfully!');
}


public function yearlyAchievementReport(Request $request)
{
    $year = $request->input('year'); 

    $query = Achievement::with('student', 'belt')
        ->when($year, function ($q) use ($year) {
            $q->whereYear('achievement_date', $year);
        });

    $achievements = $query->get();

    return view('achievement.yearly_report_print', compact('achievements', 'year'));
}



}

