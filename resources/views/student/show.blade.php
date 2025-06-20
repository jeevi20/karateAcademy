@extends('layouts.admin.master')
@section('title', 'Students Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Students Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $student->student->id }}</td>
                        </tr>
                        <tr>
                            <th>Reg.No</th>
                            <td>{{ $student->student->student_reg_no }} </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $student->name }} {{ $student->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>{{ $student->branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $student->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $student->phone }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $student->gender }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $student->dob }}</td>
                        </tr>
                        <tr>
                            <th>NIC</th>
                            <td>{{ $student->nic }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $student->address }}</td>
                        </tr>
                        <tr>
                            <th>Class Name</th>
                            <td>{{ $student->student->karateClassTemplate->class_name }}</td>
                        </tr>
                        <tr>
                            <th>Enrollment Date</th>
                            <td>{{ $student->student->enrollment_date}}</td>
                        </tr>
                        <tr>
                            <th>Experience When Join to the Institute</th>
                            <td>{{ $student->student->past_experience}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td> {{ $student->student->status}}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('student.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection





