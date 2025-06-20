@extends('layouts.admin.master')
@section('content')

<!-- Begin Page Content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="float-left">
                    <h2>Class Templates</h2>
                </div>

                <div class="float-right">
                    <!-- Back to class list -->
                    <a href="{{ route('class.index') }}" class="btn btn-dark">Back</a>

                    <!-- Add class button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('class_template.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="card-body">
                <table id="myTable" class="display">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>

                            <th>Time</th>
                            <th>Day</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karateClasses as $index => $class)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $class->class_name }}</td>
                                <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                                <td>{{ $class->day }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('class_template.edit', $class->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" title="Delete"
                                        onclick="confirmDelete({{ $class->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- Hidden Form for Delete -->
                                    <form id="deleteForm-{{ $class->id }}" action="{{ route('class_template.destroy', $class->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- End of Main Content -->
@endsection

@section('js')

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(classTemplateId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will move the schedule to trash!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the delete form specific to this row
                document.getElementById(`deleteForm-${classTemplateId}`).submit();
            }
        });
    }
</script>

@endsection
