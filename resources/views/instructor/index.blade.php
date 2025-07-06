@extends('layouts.admin.master')
@section('title','Instructor List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <h2>Instructors</h2>
                </div>

                <div class="float-right">

                    <!-- <input type="text" name="search" placeholder="Search..." value="#">
                    <button type="submit">Search</button> -->

                    <a href="" class="btn btn-outline-primary me-2">
                            <i class="fas fa-chart-line"></i> Report
                    </a>
                    <!-- back to user list -->
                    <a href="{{ route('userlist.index') }}" class="btn btn-dark" >Back</a>

                    <!-- add branchstaff button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('instructor.create') }}" >
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add
                    </a>
                </div>
                
            </div>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            <div class="card-body">
            
            <table id="myTable" class="display">
                <thead td class="table-dark">
                    
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Branch</th>
                            <th>Reg.no</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($instructors as $instructor) 
                        <tr>
                            <td>{{ $instructor->instructor->id }}</td>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->email }}</td>
                            <!-- <td>{{ $instructor->instructor->is_volunteer ? 'Volunteer' : 'Paid Instructor' }}</td> -->
                            <td> 
                                @if($instructor->instructor->is_volunteer)
                                    <span class="badge bg-success text-light">Volunteer</span>
                                @else
                                    <span class="badge bg-primary text-light">Paid Instructor</span>
                                @endif
                            </td>
                            
                            <td>{{ $instructor->branch->branch_name}}</td>
                            <td>{{ $instructor->instructor->reg_no}}</td>
                            <!-- <td>
                            <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                <option value="verified" {{ $instructor->status === 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="pending" {{ $instructor->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            </td> -->
                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('instructor.show', $instructor->id ) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('instructor.edit', $instructor->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- Delete Button -->
                                <button class="btn btn-danger btn-sm rounded-0" type="button" onclick="confirmDelete({{$instructor->id}})">
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
    function confirmDelete(instructorId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the Instructor record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Set form action dynamically based on instructorID
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/instructors/${instructorId}/destroy`;
                deleteForm.submit();
            }
        })
        
    }
</script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

@endsection


