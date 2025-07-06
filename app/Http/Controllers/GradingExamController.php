<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Announcement;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GradingExamController extends Controller
{
    public function index()
    {
        $gradingExams = Event::with('students')
            ->where('event_type', 'grading exams')
            ->get();

        return view('grading_exam.index', compact('gradingExams'));
    }

    public function admission()
    {
        $gradingExams = Event::with('students')
            ->where('event_type', 'grading exams')
            ->get();

        return view('grading_exam.admission', compact('gradingExams'));
    }

    public function viewAdmissionCard($examId, $studentId)
    {
        $exam = Event::findOrFail($examId);
        $student = Student::with('user')->where('user_id', $studentId)->firstOrFail();

        $pivotData = $exam->students()
        ->where('student_id', $student->user_id) 
        ->first()
        ?->pivot;
       


        if (!$pivotData || !$pivotData->is_admission_released) {
            abort(403, 'Admission card will be released soon!');
        }

        return view('grading_exam.admission_card', compact('exam', 'student'));
    }


    public function downloadAdmissionCard($examId, $studentId)
    {
        $exam = Event::findOrFail($examId);
        $student = Student::with('user')->where('user_id', $studentId)->firstOrFail();

        $pivotData = $exam->students()
        ->where('student_id', $student->user_id) 
        ->first()
        ?->pivot;

        if (!$pivotData || !$pivotData->is_admission_released) {
            abort(403, 'Admission card will be released soon!');
        }

        $pdf = Pdf::loadView('grading_exam.admission_card', compact('exam', 'student'));
        $filename = 'admissions/' . $student->id . '-' . $exam->id . '-admission-card.pdf';

        Storage::disk('public')->put($filename, $pdf->output());
        return Storage::disk('public')->download($filename);
    }


    public function releaseAll(Request $request)
{
    $event = Event::findOrFail($request->event_id);

    // Update pivot table: set released = true for all students of this event
    $event->students()->syncWithoutDetaching(
        $event->students->pluck('id')->mapWithKeys(function ($studentId) {
            return [$studentId => ['is_admission_released' => true]];
        })->toArray()
    );

    // Create announcement
    Announcement::create([
        'title' => 'Admission Released - ' . $event->title,
        'body' => 'Your exam admissions for "' . $event->title . '" have been released. Please check your admission card.',
        'link' =>route('grading_exam.admission'),
        'announcement_date' => Carbon::now(),
        'audience' => 'all',
        'is_active' => true,
        'created_by' => Auth::id(),
    ]);

    return back()->with('success', 'All admissions have been released and announcement created.');
}



    public function examdetail(Request $request)
    {
        $gradingExams = Event::where('event_type', 'grading exams')->get();

        $exam = null;
        if ($request->filled('examId')) {
            $exam = Event::with('students')->find($request->examId);
        }

        return view('grading_exam.exam_detail', compact('gradingExams', 'exam'));
    }
}
