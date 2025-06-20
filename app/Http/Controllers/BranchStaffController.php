<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Trash;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class BranchStaffController extends Controller
{
    
    public function index()
    {
        // Fetch branchstaff
        $branchStaffs = User::where('role_id', 2)->get();

        // Pass to view
        return view('branchstaff.index', compact('branchStaffs'));
    }


    public function create()
    {
        // Fetch branches and roles for form
        $branches = Branch::all();
        return view('branchstaff.create', compact('branches'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'nic' => 'required|string|max:12',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'password' => 'nullable|min:8',
        ]);

        
            // Create user with branch ID
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

            return redirect()->route('branchstaff.index')->with('success', 'Branch Staff created successfully!');
        

    }
    
    //show branchstaffs by id
    public function show($id)
    {
        $branchStaff = User::findOrFail($id);
        return view('branchstaff.show', compact('branchStaff'));
    }

    //edit admin
    public function edit($id)
    {
        $roles = Role::all();
        $branches = Branch::all();
        $branchStaff = User::findOrFail($id);
        return view('branchstaff.edit', compact('branchStaff','branches','roles'));
    }

    
    public function update(Request $request, $id)
        {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|in:M,F,Other', 
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|string|max:15',
                'address' => 'required|string|max:255',
                'dob' => 'required|date',
                'nic' => 'required|string|max:20',
            ]);

            // Retrieve admin by ID
            $branchStaff = User::findOrFail($id);
            

            // Update admin details
            $branchStaff->update([
                'name' => $validated['name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'gender' => $request->input('gender'),
                'dob' => $validated['dob'],
                'branch_id' => $request->input('branch_id'),
                'nic' => $validated['nic'],
            ]);

            return redirect()->route('branchstaff.index')->with('success', 'Branch Staff details updated successfully!');
        }

        //delete branchstaff
        public function destroy($id)
        {
            $branchstaff = User::findOrFail($id);
            $branchstaff->delete();

            return redirect()->route('branchstaff.index')->with('success', 'Branch Staff record moved to trash successfully!');
        }


}
