@extends('layouts.admin.master')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Student Attendance</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Summary -->
    <div class="row mb-4">
        <!-- Total -->
        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Total Attendance Records</h5>
                    <h2>{{ $attendanceSummary['total'] }}</h2>
                    <p class="text-success">Present: {{ $attendanceSummary['present'] }}</p>
                    <p class="text-danger">Absent: {{ $attendanceSummary['absent'] }}</p>
                    <p class="text-warning">Late: {{ $attendanceSummary['late'] }}</p>
                </div>
            </div>
        </div>

        <!-- By Class -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="text-center">By Class</h5>
                    <ul class="list-group">
                        @foreach($byClass as $className => $records)
                            <li class="list-group-item">
                                <strong>{{ $className ?? 'N/A' }}</strong><br>
                                Present: {{ $records->where('status', 'present')->count() }},
                                Absent: {{ $records->where('status', 'absent')->count() }},
                                Late: {{ $records->where('status', 'late')->count() }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- By Event -->
        <!-- <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="text-center">By Event</h5>
                    <ul class="list-group">
                        @foreach($byEvent as $eventName => $records)
                            <li class="list-group-item">
                                <strong>{{ $eventName ?? 'N/A' }}</strong><br>
                                Present: {{ $records->where('status', 'present')->count() }},
                                Absent: {{ $records->where('status', 'absent')->count() }},
                                Late: {{ $records->where('status', 'late')->count() }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Filter Form -->
    <!-- <form id="attendanceFilterForm" action="{{ route('student_attendance.index') }}" method="GET" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="attendance_filter_type">Filter Type</label>
                <select id="attendance_filter_type" name="filter_type" class="form-control">
                    <option value="">-- Filter Type --</option>
                    <option value="class" {{ request('filter_type') == 'class' ? 'selected' : '' }}>Class</option>
                    <option value="event" {{ request('filter_type') == 'event' ? 'selected' : '' }}>Event</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="attendance_filter_id">Select Class/Event</label>
                <select id="attendance_filter_id" name="filter_id" class="form-control">
                    <option value="">-- Select Class/Event --</option>
                    <optgroup label="Classes">
                        @foreach($karateClassTemplates as $class)
                            <option value="class_{{ $class->id }}" data-type="class"
                                {{ request('filter_id') == 'class_' . $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Events">
                        @foreach($events as $event)
                            <option value="event_{{ $event->id }}" data-type="event"
                                {{ request('filter_id') == 'event_' . $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_range">Date Range</label>
                <input type="text" name="date_range" class="form-control" id="date_range" value="{{ request('date_range') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form> -->

    <!-- Create Button -->
    <div class="mb-3 text-end">
        <a href="{{ route('student_attendance.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus-circle"></i> Record Attendance
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <table id="attendanceTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Event</th>
                        <th>Schedule</th>
                        <th>Recorded By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $index => $attendance)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $attendance->student->name ?? 'N/A' }} {{ $attendance->student->last_name ?? '' }}</td>
                            <td>
                                <span class="badge 
                                    @if($attendance->status == 'present') bg-success 
                                    @elseif($attendance->status == 'absent') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            
                            <td>{{ $attendance->event->title ?? '-' }}</td>
                            <td>{{ $attendance->schedule->schedule_date ?? '-' }}</td>
                            <td>{{ $attendance->recorder->name ?? $attendance->recorded_by ?? '-' }}</td>
                            <td>
                                
                                <a href="{{ route('student_attendance.edit', $attendance->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                 <!-- Delete Button -->
                                <button onclick="confirmDelete({{ $attendance->id }})" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                </button>
                                

                        
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form id="deleteForm" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
$(document).ready(function () {
    $('#attendanceTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-secondary' },
            { extend: 'csv', className: 'btn btn-info' },
            { extend: 'excel', className: 'btn btn-success' },
            { extend: 'pdf', className: 'btn btn-danger' },
            { extend: 'print', className: 'btn btn-primary' }
        ]
    });

    function filterAttendanceOptions(selectedType) {
        $('#attendance_filter_id option').each(function () {
            const type = $(this).data('type');
            if (!type) {
                $(this).show();
            } else {
                $(this).toggle(type === selectedType);
            }
        });
    }

    // On page load
    const initialFilterType = $('#attendance_filter_type').val();
    if (initialFilterType) {
        filterAttendanceOptions(initialFilterType);
    }

    // On change of filter_type
    $('#attendance_filter_type').on('change', function () {
        const selectedType = $(this).val();
        filterAttendanceOptions(selectedType);

        const currentSelected = $('#attendance_filter_id option:selected').data('type');
        if (currentSelected !== selectedType) {
            $('#attendance_filter_id').val('');
        }
    });

    // Date Range Picker
    $('#date_range').daterangepicker({
        locale: { format: 'YYYY-MM-DD' },
        autoUpdateInput: false
    });

    $('#date_range').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#date_range').on('cancel.daterangepicker', function () {
        $(this).val('');
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(student_attendanceId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will delete this student attendance record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let deleteForm = document.getElementById("deleteForm");
                deleteForm.action = `/attendances/student_attendance/${student_attendanceId}/destroy`;
                deleteForm.submit();
            }
        });
    }
</script>

@endsection
