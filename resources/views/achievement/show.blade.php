@extends('layouts.admin.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Achievements of {{ $student->user->name }} {{ $student->user->last_name }}</h2>
                <a href="{{ route('student.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>

        <br> 
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($achievements->isEmpty())
                <p class="text-center">No record found.</p>
            @else
                <table id="myTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Organization</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($achievements as $achievement)
                        <tr>
                            <td>{{ $achievement->formattedAchievementType }}</td>
                            <td>{{ $achievement->achievement_name }}</td>
                            <td>{{ $achievement->achievement_date }}</td>
                            <td>{{ $achievement->organization_name ?? '' }}</td>
                            <td>{{ $achievement->remarks ?? '' }}</td>
                            <td>
                                <a href="{{ route('achievement.edit', ['studentId' => $student->id, 'achievementId' => $achievement->id]) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $achievement->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <form id="deleteForm-{{ $achievement->id }}" action="{{ route('achievement.destroy', $achievement->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    function confirmDelete(achievementId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the Student's Achievement record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${achievementId}`).submit();
            }
        });
    }

    $(document).ready(function() {
        if ($('#myTable tbody tr').length > 0) {
            $('#myTable').DataTable();
        }
    });
</script>
@endsection
