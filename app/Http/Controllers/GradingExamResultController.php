<?php


namespace App\Http\Controllers;

use App\Models\GradingExamResult;
use App\Models\EventStudent;
use App\Models\Achievement;
use App\Models\Event;
use App\Models\User;
use App\Models\Belt;
use App\Models\Announcement;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradingExamResultController extends Controller
{

    public function index()
{
    $gradingExamResults = GradingExamResult::with(['student', 'instructor'])->get();

    $results = GradingExamResult::with('event.students')->get();

    $gradingExams = Event::where('event_type', 'grading exams')->get();

    $belts = Belt::all()->keyBy('id');

    foreach ($results as $result) {
    $student = $result->event?->students->firstWhere('id', $result->student_id);
    $beltId = optional($student)->pivot->belt_want_to_receive;
    $result->belt_name = $beltId && isset($belts[$beltId])
        ? $belts[$beltId]->belt_name
        : ($student ? 'No belt selected' : 'Student not found in event');
    }

    return view('grading_exam_result.index', compact('gradingExamResults', 'results', 'gradingExams', 'belts'));
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
        
        $results = GradingExamResult::with('event.students')->get();

    
        return view('grading_exam_result.create', compact('gradingExams', 'students', 'event', 'examId'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'examId' => 'required|exists:events,id',
            'student_id' => 'required|exists:users,id',
            'result' => 'required|in:fail,pass,good_pass,merit_pass',
        ]);

        $eventId = $validated['examId'];

        // Get the student model (based on user_id)
        $student = Student::where('user_id', $validated['student_id'])->first();

        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        // Check if student is registered for the event
        $eventStudent = EventStudent::where('event_id', $eventId)
            ->where('student_id', $validated['student_id'])
            ->first();

        if (!$eventStudent) {
            return back()->with('error', 'Student is not registered for this event.');
        }

        // Store grading exam result
        GradingExamResult::create([
            'event_id' => $eventId,
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

        // If pass-type result and belt is expected, award belt if not already awarded
        if (in_array($validated['result'], ['pass', 'good_pass', 'merit_pass']) && $eventStudent->belt_want_to_receive) {
            $alreadyAwarded = Achievement::where('student_id', $student->id)
                ->where('belt_id', $eventStudent->belt_want_to_receive)
                ->exists();

            if (!$alreadyAwarded) {
                Achievement::create([
                    'student_id' => $student->id,
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

    public function edit($id)
{
    $gradingExamResult = GradingExamResult::findOrFail($id);
    
    $gradingExams = Event::where('event_type', 'grading exams')->get();
    $event = Event::find($gradingExamResult->event_id);  // Make sure you use 'event_id' here, not 'exam_id'
    $examId = $gradingExamResult->event_id;

    $students = EventStudent::where('event_id', $examId)
                ->with('student')
                ->get()
                ->map(fn($eventStudent) => $eventStudent->student)
                ->filter();

    return view('grading_exam_result.edit', compact('gradingExams', 'students', 'event', 'examId', 'gradingExamResult'));
}



public function update(Request $request, $id)
{
    $validated = $request->validate([
        'result' => 'required|in:fail,pass,good_pass,merit_pass',
    ]);

    $result = GradingExamResult::findOrFail($id);

    // Add new result entry to history
    $history = json_decode($result->result_history, true) ?? [];

    $history[] = [
        'result' => $validated['result'],
        'recorded_by' => Auth::user()->name,
        'timestamp' => now()->toDateTimeString(),
    ];

    $result->update([
        'result' => $validated['result'],
        'result_entered_at' => now(),
        'result_history' => json_encode($history),
    ]);

    return redirect()->route('grading_exam_result.index')->with('success', 'Result updated successfully.');
}


public function destroy($id)
{
    $gradingExamResult = GradingExamResult::findOrFail($id);

    // Only allow admin to delete
    if (auth()->user()->role_id != 1) {
        return redirect()->back()->with('error', 'You can edit the result, you can’t delete.');
    }

    $gradingExamResult->delete();

    return redirect()->route('grading_exam_result.index')->with('success', 'Result deleted successfully.');
}

public function release(Request $request)
{
    $examId = $request->exam_id;

    // Mark as released via cache
    cache()->forever('released_exam_' . $examId, true);

    $exam = Event::findOrFail($examId);

    // Check if announcement already exists to prevent duplicates
    $existing = Announcement::where('title', 'Grading Exam Results Released')
        ->where('body', 'like', "%{$exam->name}%")
        ->first();

    if (!$existing) {
        // Create an announcement for students
        Announcement::create([
            'title' => 'Grading Exam Results Released',
            'body' => 'The results for the grading exam "' . $exam->name . '" held on ' . $exam->event_date . ' have been released. Please check your results.',
            'audience' => 'students', 
            'created_by' => auth()->id(),
            'announcement_date' => now()
        ]);
    }

    return redirect()->back()->with('success', 'Grading exam result released and announcement published.');
}



}
