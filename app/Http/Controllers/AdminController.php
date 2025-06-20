<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Trash;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index() {
        
        // Fetch all admins
        $admins = User::where('role_id', 1)->get();
        return view('admin.index', compact('admins'));
    }

    public function create() {
        // create form view
        return view('admin.create'); 
    }

    //to save admin
    public function store(Request $request)
    {
        // Define validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F,Other', 
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'nic' => 'required|string|max:12',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|min:8',
        ]);

            // Create the user 
            User::create([
                'name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'nic' => $request->input('nic'),
                'address' => $request->input('address'),
                'password' => bcrypt($request->input('password')),  // Hash the password
                'role_id' => 1, // role ID for students
            ]);

            return redirect()->route('admin.index')->with('success', 'Admin created successfully!');
        } 

    

        //admin list
        public function show($id)
        {
            $admin = User::findOrFail($id);
            return view('admin.show', compact('admin'));
        }

        //edit admin
        public function edit($id)
        {
            $admin = User::findOrFail($id);
            return view('admin.edit', compact('admin'));
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
                'address' => 'nullable|string|max:255',
                'dob' => 'nullable|date',
                'nic' => 'nullable|string|max:20',
            ]);

            // Retrieve admin by ID
            $admin = User::findOrFail($id);

            // Update admin details
            $admin->update([
                'name' => $validated['name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'dob' => $validated['dob'],
                'nic' => $validated['nic'],
                'password' => $validated['password'] ? bcrypt($validated['password']) : $admin->password,
            ]);

            return redirect()->route('admin.index')->with('success', 'Admin details updated successfully!');
        }

        //delete admin
        public function destroy($id)
        {
            $admin = User::findOrFail($id);
            $admin->delete();

            return redirect()->route('admin.index')->with('success', 'Admin record moved to trash successfully!');
        }

    }


    
    

