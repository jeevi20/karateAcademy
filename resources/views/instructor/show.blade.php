@extends('layouts.admin.master')
@section('title', 'Instructor Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <div class="float-left">
                    <h2>Instructor Details</h2>
                </div>
            
                <div class="float-right">
                <!--Add Achievement Button Link -->                 
                <!-- <a href="{{ route('salary.create', ['user_id' => $instructor->id]) }}" 
                    class="btn btn-secondary btn-sm rounded-0"
                    data-toggle="tooltip" title="Add Salary"
                    style="background-color: #060b33;">
                    <span class="badge badge-light">Add Salary</span>              
                </a> -->
                </div> 
                  
            </div>  

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $instructor->instructor->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $instructor->name }} {{ $instructor->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>{{ $instructor->branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $instructor->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $instructor->phone }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $instructor->gender }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $instructor->dob }}</td>
                        </tr>
                        <tr>
                            <th>NIC</th>
                            <td>{{ $instructor->nic }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $instructor->address }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>
                                @if($instructor->instructor->is_volunteer)
                                    <span class="badge bg-success text-light">Volunteer</span>
                                @else
                                    <span class="badge bg-primary text-light">Paid Instructor</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Reg.No</th>
                            <td>{{ $instructor->instructor->reg_no}}</td>
                        </tr>
                        <tr>
                            <th>Style Followed</th>
                            <td>{{ $instructor->instructor->style}}</td>
                        </tr>
                        <tr>
                            <th>Experience in Karate (years)</th>
                            <td>{{ $instructor->instructor->exp_in_karate}}</td>
                        </tr>
                        <tr>
                            <th>Experience as Instructors (years)</th>
                            <td> {{ $instructor->instructor->exp_as_instructor}}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('instructor.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('instructor.edit', $instructor->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection


