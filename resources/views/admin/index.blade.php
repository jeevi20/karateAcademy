@extends('layouts.admin.master')
@section('title','Admin List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2>Admins</h2>
                </div>
                <div class="float-right">
                    <!-- back to user list -->
                    <a href="{{ route('userlist.index') }}" class="btn btn-dark" >Back</a>

                    <!-- add admin button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('admin.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i>  Add
                    </a>
                </div>
            </div>
            <br>

            <div class="card-body">
                
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <table id="myTable" class="display">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($admins as $admin) 
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>{{ $admin->address }}</td>
                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <!-- Edit Button -->
                                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- Delete Button -->
                                <!-- <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="confirmDelete({{ $admin->id }})">
                                    <i class="fa fa-trash"></i>
                                </button> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Hidden Form for Delete -->
                <form id="deleteForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(adminId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the admin record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Set form action dynamically based on adminID
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/admins/${adminId}/destroy`;
                deleteForm.submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

@endsection
