<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Trash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['students', 'instructors'])->get();
        return view('branch.index', compact('branches'));
    }


    public function create() {
        // Return branch create form view
        return view('branch.create'); 
    }

    //to save branches
    public function store(Request $request) {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string',
            'email' => 'required|email',
            'phone_no' => 'required|numeric',
        ]);
    
        // Save branch
        Branch::create($validated);
    
        return redirect()->route('branch.index')->with('success', 'Branch created successfully!');
    }

    //edit branches
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branch.edit', compact('branch'));
    }

    //update edited branches
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string',
            'email' => 'required|email',
            'phone_no' => 'required|numeric',
        ]);

        $branch = Branch::findOrFail($id);
        $branch->update($validated);

        return redirect()->route('branch.show', $branch->id)->with('success', 'Branch details updated successfully!');
    }

    //show branch
    public function show($id)
    {
        $branch = Branch::with(['students', 'instructors'])->findOrFail($id);
        return view('branch.show', compact('branch'));
    }



    //delete branch
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);

        $branch->delete();

        return redirect()->route('branch.index')->with('success', 'Branch record moved to trash successfully!');
    }



}
