@extends('layouts.instructor.master')

@section('content')
<div class="container-fluid">

    <!-- Greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 text-gray-800">Welcome, Sensei {{ Auth::user()->name }}</h1>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Today's Classes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Today's Classes</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todaySchedules->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Assigned Students -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Assigned Students</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> 10  </div>
                </div>
            </div>
        </div>

       


    </div>

    <!-- Schedule and Events -->
    <div class="row">
        <!-- Today's Schedule -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body">
                    <h5 class="mb-4 text-primary">📅 Today's Classes</h5>
                    @forelse($todaySchedules as $schedule)
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="border rounded-3 p-3 shadow-sm bg-light">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $schedule->karateClassTemplate->class_name }}</strong>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No classes scheduled for today.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 rounded-4 h-100">
                <div class="card-body small">
                    <h5 class="mb-3 text-info">📌 Upcoming Events</h5>
                    @forelse($upcomingEvents as $event)
                        <div class="d-flex align-items-start mb-2">
                            <div class="me-2">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="border rounded-2 p-2 bg-light shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">{{ $event->event_name }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</small>
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ ucfirst($event->event_type) }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No upcoming events.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-secondary">Quick Actions</h6>
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        <a href="{{ route('grading_exam.index') }}" class="btn btn-outline-success btn-sm">
                            🎓 Enter Grading Marks
                        </a>
                       
                        <a href="{{ route('event.index') }}" class="btn btn-outline-primary btn-sm">
                            📅 Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements -->
    @if($announcements->count() > 0)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-secondary">📢 Announcements</h6>
                        <ul class="mt-3">
                            @foreach($announcements as $announcement)
                                <li class="mb-2">
                                    <strong>{{ $announcement->title }}</strong> - <span class="text-muted">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</span>
                                    <p class="mb-0 small text-muted">{{ $announcement->message }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
