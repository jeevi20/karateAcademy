<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Belt;
use App\Models\Trash;
use App\Models\KarateClassTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::with(['student.karateClassTemplate', 'student.achievements'])
            ->where('role_id', 4)
            ->whereHas('student', function ($query) {
                $query->whereNotNull('karate_class_template_id');
            })
            ->get();

        return view('student.index', compact('students'));
    }

    public function create()
    {
        $branches = Branch::all();
        $belts = Belt::all();
        $karateClasses = KarateClassTemplate::all();

        return view('student.create', compact('branches', 'belts', 'karateClasses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:10',
            'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'password' => 'nullable|min:6|required_if:nic,null',

            'karate_class_template_id' => 'required|exists:karate_class_templates,id',
            'enrollment_date' =>  'required|date|before_or_equal:today',
            'status' => 'required|in:Active,Inactive,Graduated,Suspended',
            'past_experience' => 'required|in:yes,no',
            'admission_granted'=> 'nullable',

            'achievement_type' => 'nullable|string|required_if:past_experience,yes',
            'achievement_name' => 'nullable|string|required_if:past_experience,yes',
            'achievement_date' => 'nullable|date|before:today|required_if:past_experience,yes',
            'organization_name' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);

        $validator->after(function ($validator) use ($request) {
            $nic = $request->input('nic');

            if (preg_match('/^\d{9}[a-zA-Z]$/', $nic)) {
                $lastChar = strtoupper(substr($nic, -1));
                if (!in_array($lastChar, ['V', 'X'])) {
                    $validator->errors()->add('nic', 'NIC must end with "V" or "X" for 9-digit NICs.');
                }
            } elseif (!preg_match('/^(\d{9}[vVxX]|\d{12})$/', $nic)) {
                $validator->errors()->add('nic', 'The NIC format is invalid. Use 123456789V/X or 12-digit format.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $password = $request->nic ? Hash::make($request->nic) : Hash::make($request->password);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'nic' => $request->nic,
            'address' => $request->address,
            'branch_id' => $request->branch_id,
            'password' => $password,
            'role_id' => 4,
        ]);

        Mail::to($user->email)->send(new UserCreatedMail($user));

        $student = Student::create([
            'user_id' => $user->id,
            'karate_class_template_id' => $request->karate_class_template_id,
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status,
            'past_experience' => $request->past_experience,
            'admission_granted'=> $request->admission_granted,
        ]);

        if ($request->past_experience === 'yes') {
            Achievement::create([
                'student_id' => $student->id,
                'belt_id' => $request->belt_id ?? null,
                'achievement_type' => $request->achievement_type,
                'achievement_name' => $request->achievement_name,
                'achievement_date' => $request->achievement_date,
                'organization_name' => $request->organization_name,
                'remarks' => $request->remarks,
            ]);
        }

        return redirect()->route('student.index')->with('success', 'Student created successfully!');
    }

    public function show($id)
    {
        $student = User::with('student.karateClassTemplate', 'student.achievements')->findOrFail($id);
        return view('student.show', compact('student'));
    }

    public function edit($id)
    {
        $user = User::with('student')->findOrFail($id);
        $branches = Branch::all();
        $belts = Belt::all();
        $karateClasses = KarateClassTemplate::all();

        return view('student.edit', compact('user', 'branches', 'belts', 'karateClasses'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $student = $user->student;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
            'nic' => 'nullable|string|max:12',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',

            'karate_class_template_id' => 'required|exists:karate_class_templates,id',
            'enrollment_date' =>  'required|date|before_or_equal:today',
            'status' => 'required|in:Active,Inactive,Graduated,Suspended',
            'admission_granted'=> 'nullable',
        ]);

        $validator->after(function ($validator) use ($request) {
            $nic = $request->input('nic');

            if (preg_match('/^\d{9}[a-zA-Z]$/', $nic)) {
                $lastChar = strtoupper(substr($nic, -1));
                if (!in_array($lastChar, ['V', 'X'])) {
                    $validator->errors()->add('nic', 'NIC must end with "V" or "X" for 9-digit NICs.');
                }
            } elseif (!preg_match('/^(\d{9}[vVxX]|\d{12})$/', $nic)) {
                $validator->errors()->add('nic', 'The NIC format is invalid. Use 123456789V/X or 12-digit format.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'nic' => $request->nic,
            'address' => $request->address,
            'branch_id' => $request->branch_id,
        ]);

        if ($student) {
            $student->update([
                'karate_class_template_id' => $request->karate_class_template_id,
                'enrollment_date' => $request->enrollment_date,
                'status' => $request->status,
                'admission_granted'=> $request->admission_granted,
            ]);
        }

        return redirect()->route('student.index')->with('success', 'Student details updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $student = $user->student;

        if ($student) {
            $student->achievements()->delete();
            Trash::storeDeletedRecord($student);
            $student->delete();
        }

        Trash::storeDeletedRecord($user);
        $user->delete();

        return redirect()->route('student.index')->with('success', 'Student record and related achievements moved to trash successfully.');
    }

    public function showEnrollmentReport(Request $request)
{
    $branches = Branch::all();
    $belts = Belt::all();

    $students = User::with(['student.karateClassTemplate', 'branch'])
        ->where('role_id', 4)
        ->when($request->branch_id, fn($q) => $q->where('branch_id', $request->branch_id))
        ->when($request->belt_id, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('belt_id', $request->belt_id)))
        ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
        ->when($request->status, fn($q) => $q->whereHas('student', fn($q2) => $q2->where('status', $request->status)))
        ->get();

    if ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $students = $students->filter(function ($student) use ($month) {
            return optional($student->student)->enrollment_date &&
                Carbon::parse($student->student->enrollment_date)->isSameMonth($month);
        });
    }

    return view('student.enrollment_report', compact('students', 'branches', 'belts'));
}

public function printEnrollmentReport(Request $request)
{
    $query = User::with(['student.karateClassTemplate', 'branch'])
        ->where('role_id', 4);

    if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
    }

    if ($request->filled('belt_id')) {
        $query->whereHas('student', fn($q) => $q->where('belt_id', $request->belt_id));
    }

    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    if ($request->filled('status')) {
        $query->whereHas('student', fn($q) => $q->where('status', $request->status));
    }

    if ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $query->whereHas('student', fn($q) => 
            $q->whereMonth('enrollment_date', $month->month)
              ->whereYear('enrollment_date', $month->year)
        );
    }

    $students = $query->get();
    $month = $request->input('month');
    return view('student.enrollment_report_print', compact('students', 'month'));

    
}

public function downloadEnrollmentReportPDF(Request $request)
{
    $query = User::with(['student.karateClassTemplate', 'branch'])
        ->where('role_id', 4);

    if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
    }

    if ($request->filled('belt_id')) {
        $query->whereHas('student', fn($q) => $q->where('belt_id', $request->belt_id));
    }

    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    if ($request->filled('status')) {
        $query->whereHas('student', fn($q) => $q->where('status', $request->status));
    }

    if ($request->filled('month')) {
        $month = Carbon::parse($request->month);
        $query->whereHas('student', fn($q) => 
            $q->whereYear('enrollment_date', $month->year)
              ->whereMonth('enrollment_date', $month->month)
        );
    }

    $students = $query->get();

    $pdf = Pdf::loadView('student.enrollment_report_pdf', compact('students'));

    return $pdf->download('enrollment_report.pdf');
}
}
