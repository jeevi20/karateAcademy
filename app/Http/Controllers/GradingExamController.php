<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use App\Models\Payment;
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
        
        $payment = Payment::where('student_id', $student->id)
            ->where('event_id', $exam->id)
            ->first();

        return view('grading_exam.admission_card', compact('exam', 'student', 'payment'));
    }

    public function downloadAdmissionCard($examId, $studentId)
    {
        $exam = Event::findOrFail($examId);
        $student = Student::with('user')->where('user_id', $studentId)->firstOrFail();
        $payment = Payment::where('student_id', $student->id)
            ->where('event_id', $exam->id)
            ->first();

        $pdf = Pdf::loadView('grading_exam.admission_card', compact('exam', 'student', 'payment'));
        $filename = 'admissions/' . $student->id . '-' . $exam->id . '-admission-card.pdf';

        Storage::disk('public')->put($filename, $pdf->output());
        return Storage::disk('public')->download($filename);
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
