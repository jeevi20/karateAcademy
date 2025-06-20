<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Event;
use App\Models\Belt;
use App\Models\EventStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'createdBy'])->get();
        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        $students = User::where('role_id', 4)->get();
        $gradingExams = Event::with('students')->where('event_type', 'grading exams')->get();
        $belts = Belt::all();
        return view('payment.create', compact('gradingExams', 'students', 'belts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required',
            'payment_category' => 'required',
            'amount' => 'required|integer',
            'date_paid' => 'required|date',
            'notes' => 'nullable|string',
            'event_id' => 'required_if:payment_category,Grading Exam|exists:events,id',
            'belt_want_to_receive' => [
                'nullable',
                'required_if:payment_category,Grading Exam',
                'exists:belts,id'
            ],
        ], [
            'belt_want_to_receive.required_if' => 'Please select the belt the student wants to receive.',
            'belt_want_to_receive.exists' => 'The selected belt is invalid.',
        ]);

        $referenceNo = Payment::generateReferenceNo();

        $payment = Payment::create([
            'student_id' => $request->input('student_id'),
            'created_by' => Auth::id(),
            'reference_no' => $referenceNo,
            'payment_category' => $request->input('payment_category'),
            'amount' => $request->input('amount'),
            'date_paid' => $request->input('date_paid'),
            'notes' => $request->input('notes', 'N/A'),
            'event_id' => $request->input('event_id'),
            'belt_want_to_receive' => $request->input('belt_want_to_receive'),
        ]);

        if ($request->payment_category === 'Grading Exam' && $request->event_id) {
            EventStudent::create([
                'event_id' => $request->event_id,
                'student_id' => $request->student_id,
                'belt_want_to_receive' => $request->belt_want_to_receive,
            ]);
        }

        $this->generateAdmissionCard($payment);

        return redirect()->route('payment.index')->with('success', 'Payment record added successfully!');
    }

    protected function generateAdmissionCard($payment)
    {
        $event = Event::find($payment->event_id);
        if ($event && $payment->payment_category === 'Grading Exam') {
            $pdf = PDF::loadView('grading_exam.admission_card', ['payment' => $payment, 'event' => $event]);
            $admissionCardPath = 'admissions/' . $payment->student_id . '-' . $event->id . '-admission-card.pdf';
            $pdf->save(storage_path('app/public/' . $admissionCardPath));
            $payment->update(['admission_card_path' => $admissionCardPath]);
        }
    }

    public function show($id)
    {
        $payment = Payment::with(['student', 'createdBy'])->findOrFail($id);
        return view('payment.show', compact('payment'));
    }

    public function edit($id)
{
    $payment = Payment::findOrFail($id);
    $students = User::where('role_id', 4)->get();
    $gradingExams = Event::where('event_type', 'grading exams')->get();
    $belts = Belt::all();
    return view('payment.edit', compact('payment', 'students', 'gradingExams', 'belts'));
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'student_id' => 'required',
        'payment_category' => 'required',
        'amount' => 'required|integer',
        'date_paid' => 'required|date',
        'notes' => 'nullable|string',
        'event_id' => 'required_if:payment_category,Grading Exam|exists:events,id',
        'belt_want_to_receive' => [
            'nullable',
            'required_if:payment_category,Grading Exam',
            'exists:belts,id'
        ],
    ], [
        'belt_want_to_receive.required_if' => 'Please select the belt the student wants to receive.',
        'belt_want_to_receive.exists' => 'The selected belt is invalid.',
    ]);

    $payment = Payment::findOrFail($id);
    $payment->update([
        'student_id' => $request->input('student_id'),
        'payment_category' => $request->input('payment_category'),
        'amount' => $request->input('amount'),
        'date_paid' => $request->input('date_paid'),
        'notes' => $request->input('notes', 'N/A'),
        'event_id' => $request->input('event_id'),
        'belt_want_to_receive' => $request->input('belt_want_to_receive'),
    ]);

    return redirect()->route('payment.index')->with('success', 'Payment details updated successfully!');
}

    

    public function downloadReceipt($id)
    {
        $payment = Payment::with(['student.branch', 'createdBy'])->findOrFail($id);
        $pdf = PDF::loadView('payment.receipt', compact('payment'));
        $filename = "Receipt-{$payment->reference_no}.pdf";
        return $pdf->download($filename);
    }
}
