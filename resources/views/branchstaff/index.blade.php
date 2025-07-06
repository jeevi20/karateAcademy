@extends('layouts.admin.master')
@section('title','Branchstaff List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2>Branchstaffs</h2>
                </div>
                <div class="float-right">

                    <!-- back to user list -->
                    <a href="{{ route('userlist.index') }}" class="btn btn-dark" >Back</a>

                    <!-- add branchstaff button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('branchstaff.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add 
                    </a>

                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            
                <table id="myTable" class="display">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Branch</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($branchStaffs as $branchstaff) 
                        <tr>
                            <td>{{ $branchstaff->id }}</td>
                            <td>{{ $branchstaff->name }}</td>
                            <td>{{ $branchstaff->email }}</td>
                            <td>{{ $branchstaff->phone }}</td>
                            <td>{{ $branchstaff->branch->branch_name}}</td>
                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('branchstaff.show', $branchstaff->id ) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('branchstaff.edit', $branchstaff->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- Delete Button -->
                                <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="confirmDelete({{ $branchstaff->id}})">
                                    <i class="fa fa-trash"></i>
                                </button>
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
    function confirmDelete(branchstaffId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the Branch staff record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Set form action dynamically based on branchstaffID
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/branchstaffs/${branchstaffId}/destroy`;
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
