<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Event;
use App\Models\Belt;
use App\Models\Branch;
use App\Models\EventStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PaymentConformationNotification;

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
            'amount' => 'required|integer|min:1',
            'date_paid' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string',
            'event_id' => 'nullable|required_if:payment_category,Grading Exam|exists:events,id',
            'admission_card_path' => 'nullable',
            'belt_want_to_receive' => [
                'nullable',
                'required_if:payment_category,Grading Exam',
                'exists:belts,id',
            ],
        ], [
            'belt_want_to_receive.required_if' => 'Please select the belt the student wants to receive.',
            'belt_want_to_receive.exists' => 'The selected belt is invalid.',
        ]);

        $studentId = $request->student_id;
        $paymentCategory = $request->payment_category;
        $eventId = $request->event_id;
        $datePaid = $request->date_paid;

        // 💡 Constraint 1: Registration (only once)
        if ($paymentCategory === 'Registration') {
            $alreadyRegistered = Payment::where('student_id', $studentId)
                ->where('payment_category', 'Registration')
                ->exists();

            if ($alreadyRegistered) {
                return back()->with('error', 'Registration payment already made.');
            }
        }

        // 💡 Constraint 2: Monthly class (once per calendar month)
        if ($paymentCategory === 'Monthly Class') {
            $alreadyPaidThisMonth = Payment::where('student_id', $studentId)
                ->where('payment_category', 'Monthly Class')
                ->whereMonth('date_paid', date('m', strtotime($datePaid)))
                ->whereYear('date_paid', date('Y', strtotime($datePaid)))
                ->exists();

            if ($alreadyPaidThisMonth) {
                return back()->with('error', 'Monthly class payment already made for this month.');
            }
        }

        // 💡 Constraint 3: Grading Exam (only once per event)
        if ($paymentCategory === 'Grading Exam' && $eventId) {
            $alreadyPaidForEvent = Payment::where('student_id', $studentId)
                ->where('payment_category', 'Grading Exam')
                ->where('event_id', $eventId)
                ->exists();

            if ($alreadyPaidForEvent) {
                return back()->with('error', 'You have already paid for this grading exam.');
            }
        }

        $referenceNo = Payment::generateReferenceNo();

        $payment = Payment::create([
            'student_id' => $studentId,
            'created_by' => Auth::id(),
            'reference_no' => $referenceNo,
            'payment_category' => $paymentCategory,
            'amount' => $request->amount,
            'date_paid' => $datePaid,
            'notes' => $request->notes ?? 'N/A',
            'event_id' => $eventId,
            'belt_want_to_receive' => $request->belt_want_to_receive,
        ]);

        if ($paymentCategory === 'Grading Exam' && $eventId) {
            EventStudent::create([
                'event_id' => $eventId,
                'student_id' => $studentId,
                'belt_want_to_receive' => $request->belt_want_to_receive,
                'admission_card_path' => $request->admission_card_path,
            ]);

            $this->generateAdmissionCard($payment);
            $payment->student->update(['admission_granted' => true]);
        }

        try {
            \Log::info('Sending to: ' . $payment->student->email);
            Mail::to($payment->student->email)->send(new PaymentConformationNotification($payment));
        } catch (\Exception $e) {
            \Log::error('Email failed to send: ' . $e->getMessage());
        }

        return redirect()->route('payment.index')->with('success', 'Payment recorded. Confirmation email sent!');
    }


    protected function generateAdmissionCard($payment)
{
    $exam = Event::find($payment->event_id); 
    
    $student = $payment->student;

    if ($exam && $payment->payment_category === 'Grading Exam') {
        $pdf = PDF::loadView('grading_exam.admission_card', [
            'payment' => $payment,
            'exam' => $exam,
            'student' => $student,
        ]);

        $admissionCardPath = 'admissions/' . $payment->student_id . '-' . $exam->id . '-admission-card.pdf';
        $pdf->save(storage_path('app/public/' . $admissionCardPath));
        $payment->update(['admission_card_path' => $admissionCardPath]);
    }
}



    public function show($id)
    {
        $students = User::where('role_id', 4)->get();
        $payment = Payment::with(['student', 'createdBy'])->findOrFail($id);
        return view('payment.show', compact('payment','students'));
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
        'amount' => 'required|integer|min:1',
        'date_paid' => 'required|date|before_or_equal:today',
        'notes' => 'nullable|string',
        'event_id' => 'required_if:payment_category,Grading Exam|exists:events,id',
        'belt_want_to_receive' => [
            'nullable',
            'required_if:payment_category,Grading Exam',
            'exists:belts,id'
        ],
        'admission_card_path' => 'nullable',
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
        'admission_card_path' => $request->input('admission_card_path'),
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

    public function AnnualPaymentReport(Request $request)
{
    $branches = Branch::all();

    $year = $request->input('enable_year') ? ($request->input('year') ?? now()->year) : null;

    $query = Payment::with('student.branch');

    if ($year) {
        $query->whereYear('created_at', $year);
    }

    if ($request->filled('branch_id')) {
        $query->whereHas('student', fn($q) =>
            $q->where('branch_id', $request->branch_id)
        );
    }

    $payments = $query->get();
    $totalPaid = $payments->sum('amount');

    return view('payment.annual_report', compact('totalPaid', 'year', 'branches'));
}

public function AnnualPaymentReportPrint(Request $request)
{
    $branches = Branch::all();

    $year = $request->input('enable_year') ? ($request->input('year') ?? now()->year) : null;

    $query = Payment::with('student.branch');

    if ($year) {
        $query->whereYear('created_at', $year);
    }

    if ($request->filled('branch_id')) {
        $query->whereHas('student', fn($q) =>
            $q->where('branch_id', $request->branch_id)
        );
    }

    $payments = $query->get();
    $totalPaid = $payments->sum('amount');

    return view('payment.annual_report_print', compact('totalPaid', 'year', 'branches'));
}


}
