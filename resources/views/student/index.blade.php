@extends('layouts.admin.master')

@section('title', 'Students List')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Students</h2>
                <div>
                    <div>
                        <a href="{{ route('student.enrollment_report') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-chart-line"></i> Report
                        </a>
                        <a href="{{ route('userlist.index') }}" class="btn btn-dark me-2">Back</a>
                        <a class="btn btn-primary btn-md btn-rounded" href="{{ route('student.create') }}">
                            <i class="mdi mdi-plus-circle mdi-18px"></i> <i class="fas fa-plus" style="color:white"></i> Add
                        </a>
                    </div>

                    
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body">
                <table id="myTable" class="display table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Reg No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Class Name</th>
                            <th>Actions</th>
                            <th>Achievements</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->student->student_reg_no ?? 'N/A' }}</td>
                                <td>{{ $student->name }} {{ $student->last_name }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td>{{ $student->student->karateClassTemplate->class_name ?? 'No Class Assigned' }}</td>
                                <td>
                                    <a href="{{ route('student.show', $student->id) }}" class="btn btn-info btn-sm rounded-0" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-success btn-sm rounded-0" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <!-- Delete Button -->
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $student->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                
                                <!-- Achievements Dropdown -->
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-sm rounded-0 dropdown-toggle {{ $student->student->achievements->count() > 0 ? 'btn-info' : 'btn-secondary' }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            🏆 Achievements ({{ $student->student->achievements->count() }})
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if ($student->student->achievements->count() > 0)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('achievement.show', ['studentId' => $student->student->id]) }}">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{ route('achievement.create', ['studentId' => $student->student->id]) }}">
                                                    <i class="fa fa-plus-circle"></i> Add Achievement
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Hidden DELETE Form -->
                    <form id="deleteForm" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- SweetAlert for Delete Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(studentId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will delete the student record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/students/${studentId}/destroy`;
                deleteForm.submit();
            }
        })
    }
</script>

<!-- DataTable Script -->
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
@endsection
