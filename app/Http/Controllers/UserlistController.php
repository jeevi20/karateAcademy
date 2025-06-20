<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserlistController extends Controller
{
    public function index()
    {
        $adminCount = User::where('role_id', 1)->count();
$branchstaffCount = User::where('role_id', 2)->count();
$instructorCount = User::where('role_id', 3)->count();
$studentCount = User::where('role_id', 4)->count();



        return view('userlist.index', compact('adminCount', 'branchstaffCount', 'instructorCount', 'studentCount'));
    }
}
