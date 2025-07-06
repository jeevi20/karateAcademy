@extends('layouts.branchstaff.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Branch Staff Dashboard</h1>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Branch Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Branch
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $branch->branch_name ?? 'No Branch Assigned' }}
                    </div>
                    <div class="text-muted mt-1">
                        {{ $branch->branch_address ?? 'No location available' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Students
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $students->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Instructors -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Total Instructors
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $instructors->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Summary and Total Payments -->
    <div class="row">
        <!-- Attendance Summary -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card  border-left-primary shadow h-100 py-2">
                
                <div class="card-body">
                    <h6 class="text-uppercase text-primary">Today's Attendance</h6>
                    <p class="mb-0">
                        Present: {{ $attendance['present'] }} |
                        Absent: {{ $attendance['absent'] }} |
                        Late: {{ $attendance['late'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Payments -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Total Payments
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rs. {{ number_format($payments->sum('amount'), 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedules Today and Upcoming Events -->
    <div class="row">
        <!-- Schedules Today -->
        <div class="col-md-6 mb-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body">
                    <h5 class="mb-4">📅 Schedules - {{ \Carbon\Carbon::today()->format('d M Y') }}</h5>

                    @forelse($schedulesToday as $branchName => $branchSchedules)
                        <h6 class="text-primary mb-3">{{ $branchName }}</h6>

                        @foreach($branchSchedules->take(5) as $schedule)
                            <div class="d-flex align-items-start mb-4">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="border rounded-3 p-3 shadow-sm bg-light">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $schedule->karateClassTemplate->class_name ?? 'Class' }}</strong>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($branchSchedules->count() > 5)
                            <div class="text-end mb-4">
                                <a href="{{ route('schedule.index') }}" class="btn btn-sm btn-outline-primary">
                                    View all for {{ $branchName }}
                                </a>
                            </div>
                        @endif
                    @empty
                        <div class="text-dark">No schedules for today 🚫</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-md-6 mb-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body small">
                    <h6 class="mb-3">📌 Upcoming Events</h6>

                    @forelse($upcomingEvents as $event)
                        <div class="d-flex align-items-start mb-2">
                            <div class="me-2">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="border rounded-2 p-2 bg-light shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold" style="font-size: 0.85rem;">{{ $event->event_name }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</small>
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ ucfirst($event->event_type) }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small">No upcoming events 📭</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
<div class="col-12 mb-4">
    <div class="card shadow h-100 py-2">
        <div class="card-body">
            <h6 class="text-uppercase text-secondary mb-3">Quick Links</h6>

            <div class="d-flex flex-wrap gap-3 justify-content-start">
    <a href="{{ route('student.index') }}" class="btn btn-outline-primary btn-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px;">
        📚 View Students
    </a>
    <a href="{{ route('schedule.index') }}" class="btn btn-outline-success btn-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px;">
        🕓 Manage Schedules
    </a>
    <a href="{{ route('event.index') }}" class="btn btn-outline-info btn-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px;">
        📅 View Events
    </a>
    <a href="{{ route('payment.index') }}" class="btn btn-outline-warning btn-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px;">
        💰 View Payments
    </a>
</div>


        </div>
    </div>
</div>


</div>
@endsection
