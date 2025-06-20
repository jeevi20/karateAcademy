@extends('layouts.admin.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Branch Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $branch->id }}</td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>{{ $branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>Branch Code</th>
                            <td>{{ $branch->branch_code }}</td>
                        </tr>
                        <tr>
                            <th>Province Code</th>
                            <td>{{ $branch->province_code }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $branch->email }}</td>
                        </tr>
                        <tr>
                            <th>Branch Address</th>
                            <td>{{ $branch->branch_address }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>{{ $branch->phone_no }}</td>
                        </tr>
                        <tr>
                            <th>Total Students</th>
                            <td>{{ $branch->students->count() }}</td>
                        </tr>
                        <tr>
                            <th>Total Instructors</th>
                            <td>{{ $branch->instructors->count() }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('branch.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('branch.edit', $branch->id) }}" class="btn btn-warning">Edit</a>

                <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="confirmDelete({{ $branch->id }})">
                    Delete
                </button>
                    
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
    function confirmDelete(branchId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This will permanently delete the branch record.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Set the form action dynamically
            let deleteForm = document.getElementById("deleteForm");
            deleteForm.action = `/branches/${branchId}/destroy`;
            deleteForm.submit();
        }
    });
}
</script>

@endsection