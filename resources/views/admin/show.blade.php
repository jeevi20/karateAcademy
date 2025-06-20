@extends('layouts.admin.master')
@section('title', 'Admin Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Branchstaff Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $admin->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $admin->name }} {{ $admin->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $admin->phone }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $admin->gender }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $admin->dob }}</td>
                        </tr>
                        <tr>
                            <th>NIC</th>
                            <td>{{ $admin->nic }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $admin->address }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection
