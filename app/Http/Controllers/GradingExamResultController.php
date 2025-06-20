<?php


namespace App\Http\Controllers;

use App\Models\GradingExamResult;
use App\Models\EventStudent;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradingExamResultController extends Controller
{
    public function index()
    {
        $results = GradingExamResult::with(['student', 'instructor', 'event'])->latest()->get();
        $gradingExams = Event::where('event_type', 'grading exams')->get();

        return view('grading_exam_result.index', compact('results' , 'gradingExams'));
    }

    public function create(Request $request)
    {
        $examId = $request->query('examId');
    
        $event = Event::findOrFail($examId);
    
        $gradingExams = Event::where('event_type', 'grading exams')->get();
    
        $students = EventStudent::where('event_id', $examId)
            ->with('student')
            ->get()
            ->map(fn($eventStudent) => $eventStudent->student)
            ->filter(); // Remove null values
    
        return view('grading_exam_result.create', compact('gradingExams', 'students', 'event', 'examId'));
    }






    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'student_id' => 'required|exists:users,id',
            'result' => 'required|in:fail,pass,good_pass,merit_pass',
        ]);

        $eventStudent = EventStudent::where('event_id', $validated['event_id'])
                        ->where('student_id', $validated['student_id'])
                        ->first();

        if (!$eventStudent) {
            return back()->with('error', 'Student is not registered for this event.');
        }

        $gradingExamResult = GradingExamResult::create([
            'event_id' => $validated['event_id'],
            'student_id' => $validated['student_id'],
            'instructor_id' => Auth::id(),
            'result' => $validated['result'],
            'result_entered_at' => now(),
            'result_history' => json_encode([
                [
                    'result' => $validated['result'],
                    'recorded_by' => Auth::user()->name,
                    'timestamp' => now()->toDateTimeString(),
                ]
            ])
        ]);

        $message = 'Result recorded successfully.';

        if (in_array($validated['result'], ['pass', 'good_pass', 'merit_pass']) && $eventStudent->belt_want_to_receive) {
            
            $alreadyAwarded = Achievement::where('student_id', $validated['student_id'])
                                ->where('belt_id', $eventStudent->belt_want_to_receive)
                                ->exists();

            if (!$alreadyAwarded) {
                Achievement::create([
                    'student_id' => $validated['student_id'],
                    'belt_id' => $eventStudent->belt_want_to_receive,
                    'achievement_type' => 'academy_belt',
                    'achievement_name' => 'Belt Awarded',
                    'achievement_date' => now(),
                    'organization_name' => 'Academy of Japanese Shotokan Karate International',
                    'remarks' => 'Awarded after passing grading examination',
                ]);

                $message .= ' Belt awarded successfully!';
            }
        }

        return redirect()->route('grading_exam_result.index')->with('success', $message);
    }

    public function edit(GradingExamResult $gradingExamResult)
    {
        return view('grading_exam_results.edit', compact('gradingExamResult'));
    }

    public function update(Request $request, GradingExamResult $gradingExamResult)
    {
        $validated = $request->validate([
            'result' => 'required|in:fail,pass,good_pass,merit_pass',
        ]);

        $history = $gradingExamResult->result_history ? json_decode($gradingExamResult->result_history, true) : [];

        $history[] = [
            'result' => $validated['result'],
            'recorded_by' => Auth::user()->name,
            'timestamp' => now()->toDateTimeString(),
        ];

        $gradingExamResult->update([
            'result' => $validated['result'],
            'result_history' => json_encode($history),
        ]);

        return redirect()->route('grading_exam_result.index')->with('success', 'Result updated successfully.');
    }

    public function destroy(GradingExamResult $gradingExamResult)
    {
        $gradingExamResult->delete();

        return redirect()->route('grading_exam_result.index')->with('success', 'Result deleted successfully.');
    }
}
