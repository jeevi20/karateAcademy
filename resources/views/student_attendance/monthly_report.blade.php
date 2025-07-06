@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h3 class="text-center mb-4">Monthly Student Attendance Summary</h3>

    <form method="GET" action="{{ route('student_attendance.monthly_report') }}" class="mb-4 row g-2">
        <div class="col">
            <select name="branch_id" class="form-control">
                <option value="">All Branches</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="class_id" class="form-control">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->class_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <select name="student_id" class="form-control">
                <option value="">All Students</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <input type="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col">
            <a 
                href="{{ route('student_attendance.monthly_report_print', request()->query()) }}" 
                target="_blank" 
                class="btn btn-secondary"
            >
        Print
    </a>
        </div>
    </form>

    @if($summary->isNotEmpty())
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Total Sessions</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Late</th>
                    <th>Attendance %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary as $record)
                    <tr>
                        <td>{{ $record['student'] }}</td>
                        <td>{{ $record['total'] }}</td>
                        <td>{{ $record['present'] }}</td>
                        <td>{{ $record['absent'] }}</td>
                        <td>{{ $record['late'] }}</td>
                        <td>{{ $record['percentage'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-muted">No attendance data found for selected filters.</p>
    @endif
</div>
@endsection
