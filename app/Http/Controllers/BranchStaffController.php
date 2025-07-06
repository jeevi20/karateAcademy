<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BranchStaffController extends Controller
{
    public function index()
    {
        $branchStaffs = User::where('role_id', 2)->get();
        return view('branchstaff.index', compact('branchStaffs'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('branchstaff.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
            'nic' => 'required', 'string', 'max:12',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'password' => 'nullable|min:8',
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

        User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'nic' => $request->input('nic'),
            'address' => $request->input('address'),
            'branch_id' => $request->input('branch_id'),
            'role_id' => 2,
            'password' => Hash::make($request->input('password')),
        ]);

        Mail::to($user->email)->send(new UserCreatedMail($user, $password));

        return redirect()->route('branchstaff.index')->with('success','Branch Staff created successfully!');

        
    }

    public function show($id)
    {
        $branchStaff = User::findOrFail($id);
        return view('branchstaff.show', compact('branchStaff'));
    }

    public function edit($id)
    {
        $roles = Role::all();
        $branches = Branch::all();
        $branchStaff = User::findOrFail($id);
        return view('branchstaff.edit', compact('branchStaff', 'branches', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['required', 'string', 'regex:/^(?:0|\+94)(7\d{8})$/'],
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'nic' => 'required', 'string', 'max:12',
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

        $branchStaff = User::findOrFail($id);

        $branchStaff->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'branch_id' => $request->input('branch_id'),
            'nic' => $request->input('nic'),
        ]);

        return redirect()->route('branchstaff.index')->with('success', 'Branch Staff details updated successfully!');
    }

    public function destroy($id)
    {
        $branchstaff = User::findOrFail($id);
        $branchstaff->delete();

        return redirect()->route('branchstaff.index')->with('success', 'Branch Staff record moved to trash successfully!');
    }
}
