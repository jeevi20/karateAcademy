<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Models\instructor;
use App\Models\Trash;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch branchstaff
        $instructors = User::where('role_id', 3)->get();

        //$query = User::where('role_id', 3);

        // // Apply search filter if provided
        // if ($request->has('search')) {
        //     $query->where('name', 'like', '%' . $request->search . '%')
        //         ->orWhere('email', 'like', '%' . $request->search . '%')
        //         ->orWhere('status', 'like', '%' . $request->search . '%');
        // }

        // // Apply sorting if provided
        // if ($request->has('sort')) {
        //     $query->orderBy($request->sort, $request->order ?? 'asc');
        //}

        // Pass to view
        return view('instructor.index' , compact('instructors'  ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch branches and roles for form
        $branches = Branch::all();
        return view('instructor.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Validate input data
        $validated = $request->validate([

        // User validation
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:M,F,Other',
        'dob' => 'required|date|before:today',
        'email' => 'required|email|unique:users,email',
        'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
        'nic' => 'required|string|max:12',
        'address' => 'nullable|string|max:255',
        'branch_id' => 'required|exists:branches,id',
        'is_volunteer' => 'required|in:0,1',
        'password' => 'nullable|min:8',

        // Instructor validation
        'reg_no' => 'required|string|max:255|unique:instructors,reg_no',
        'style' => 'required|string|max:255',
        'exp_in_karate' => 'required|integer',
        'exp_as_instructor' => 'required|integer|min:0',
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
       
        // Create the user record
        $user = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'nic' => $request->input('nic'),
            'address' => $request->input('address'),
            'branch_id' => $request->input('branch_id'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 3,

        ]);

        Mail::to($user->email)->send(new UserCreatedMail($user));

        //create instructor record
        Instructor::create([
            'user_id' => $user->id, 
            'is_volunteer' => $request->is_volunteer,
            'reg_no' => $request->input('reg_no'),
            'style' => $request->input('style'),
            'exp_in_karate' => $request->input('exp_in_karate'),
            'exp_as_instructor' => $request->input('exp_as_instructor'),
        ]);

        return redirect()->route('instructor.index')->with('success', 'Instructor created successfully!'); 
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $instructor = User::findOrFail($id);
        return view('instructor.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('instructor')->findOrFail($id);

        $branches = Branch::all();//for dropdown
        return view('instructor.edit', compact('user', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $instructor = $user->instructor;

        // Validate input data
        $validated = $request->validate([
            // User validation
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
            'nic' => 'required|string|max:12',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            

            // Instructor validation
            'reg_no' => 'required|string|max:255|unique:instructors,reg_no,' . $user->instructor->id,
            'style' => 'required',
            'is_volunteer' => 'required|in:0,1',
            'exp_in_karate' => 'required|integer',
            'exp_as_instructor' => 'required|integer|min:0',
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

        // Fetch user by id
        $user = User::findOrFail($id);

        // Update the user details
        $user->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'nic' => $request->input('nic'),
            'address' => $request->input('address'),
            'branch_id' => $request->input('branch_id'),
        ]);

        

        // Update the instructor details
        $instructor = Instructor::where('user_id', $user->id)->first();

        if ($instructor) {
            $instructor->update([
                'reg_no' => $request->input('reg_no'),
                'style' => $request->input('style'),
                'exp_in_karate' => $request->input('exp_in_karate'),
                'exp_as_instructor' => $request->input('exp_as_instructor'),
                'is_volunteer' => $request->is_volunteer
            ]);
        }
        return redirect()->route('instructor.index')->with('success', 'Instructor details updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
        {
            $instructor = User::findOrFail($id);
            $instructor->delete();

            return redirect()->route('instructor.index')->with('success', 'Instructor record moved to trash successfully!');
        }
}
