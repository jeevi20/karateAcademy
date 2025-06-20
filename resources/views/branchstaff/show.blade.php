@extends('layouts.admin.master')
@section('title', 'Branchstaff Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Branch Staff Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $branchStaff->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $branchStaff->name }} {{ $branchStaff->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>{{ $branchStaff->branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $branchStaff->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $branchStaff->phone }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $branchStaff->gender }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $branchStaff->dob }}</td>
                        </tr>
                        <tr>
                            <th>NIC</th>
                            <td>{{ $branchStaff->nic }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $branchStaff->address }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('branchstaff.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('branchstaff.edit', $branchStaff->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection
