@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="float-left">
                        <h1>Schedules</h1>
                    </div>

                    <div class="float-right">
                        <!-- class index -->
                        <a href="{{ route('class.index') }}" class="btn btn-dark" >Back</a>

                        <!-- add student button -->
                        <a class="btn btn-primary btn-md btn-rounded" href="{{route('schedule.create')}}" >
                            <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add
                        </a>
                    </div>

                </div>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row">
                    <!-- Total Schedules -->
                    <div class="col-md-4 col-sm-12 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Schedules</h5>
                                <h1>{{ $schedules->count() }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead td class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Class Name</th>
                                <th>Branch</th>
                                <th>Instructor</th>
                                <th>Schedule Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $index => $schedule)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $schedule->karateClassTemplate->class_name }}</td>
                                    <td>{{ $schedule->branch->branch_name  }}</td>

                                    <td>
                                        
                                            {{ $schedule->instructor->name . ' ' . $schedule->instructor->last_name }}
                                        
                                    </td>
                                    <td>{{ $schedule->schedule_date }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($schedule->status == 'scheduled') badge-primary
                                            @elseif($schedule->status == 'completed') badge-success
                                            @else badge-danger
                                            @endif">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('schedule.edit', $schedule->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" title="Delete"
                                            onclick="confirmDelete({{$schedule->id}})">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Hidden Form for Delete -->
                                        <form id="deleteForm" method="POST" style="display: none;">
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
</div>
@endsection

@section('js')

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(scheduleId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will move the schedule to trash!.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Set form action dynamically based on instructorID
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/schedules/${scheduleId}/destroy`;
                deleteForm.submit();
            }
        })
        
    }
</script>

@endsection

