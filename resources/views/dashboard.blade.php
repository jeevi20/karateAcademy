@extends('layouts.admin.master')

@section('content')
<div class="container-fluid">
    <!-- Header with Reports Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Dashboard</h1>
        <a href="" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-chart-line me-1"></i> Reports
        </a>
    </div>
    <div class="container py-4">
        <div class="row">
            <!-- Card 1: Branch Staff & Instructors -->
            <div class="col-md-6 mb-4">
                
                    <div class="card  border-left-primary shadow h-100 py-2">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-6 border-end bg-primary bg-opacity-10 p-4">
                                <a href="{{ route('branchstaff.index') }}" class="text-decoration-none text-dark d-block">
                                    <i class="fas fa-user-tie fa-2x mb-2 text-primary"></i>
                                    <h6>Branch Staff</h6>
                                    <h3 class="count" data-count="{{ $branchStaffCount }}">0</h3>
                                </a>
                            </div>
                            <div class="col-6 bg-info bg-opacity-10 p-4">
                                <a href="{{ route('instructor.index') }}" class="text-decoration-none text-dark d-block">
                                    <i class="fas fa-chalkboard-teacher fa-2x mb-2 text-info"></i>
                                    <h6>Instructors</h6>
                                    <h3 class="count" data-count="{{ $instructorCount }}">0</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Students & Branches -->
            <div class="col-md-6 mb-4">
                
                <div class="card  border-left-primary shadow h-100 py-2">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-6 border-end bg-success bg-opacity-10 p-4">
                                <a href="{{ route('student.index') }}" class="text-decoration-none text-dark d-block">
                                    <i class="fas fa-user-graduate fa-2x mb-2 text-success"></i>
                                    <h6>Students</h6>
                                    <h3 class="count" data-count="{{ $studentCount }}">0</h3>
                                </a>
                            </div>
                            <div class="col-6 bg-warning bg-opacity-10 p-4">
                                <a href="{{ route('branch.index') }}" class="text-decoration-none text-dark d-block">
                                    <i class="fas fa-code-branch fa-2x mb-2 text-warning"></i>
                                    <h6>Branches</h6>
                                    <h3 class="count" data-count="{{ $branchCount }}">0</h3>
                                </a>
                            </div>
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
                        <h5 class="mb-4">📅 Schedules - {{ \Carbon\Carbon::today()->format(' d M Y') }}</h5>

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
                                                    {{ \Carbon\Carbon::parse($schedule->karateClassTemplate->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->karateClassTemplate->end_time)->format('h:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($branchSchedules->count() > 5)
                                <div class="text-end mb-4">
                                    <a href="{{ route('schedule.index') }}" class="btn btn-sm btn-outline-primary">View all for {{ $branchName }}</a>
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
                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.75rem;">
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

        <!-- Charts Row -->
        <div class="row g-4">
            <!-- Student Enrollment Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded-4 border-0 h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Student Enrollment by Branch (Monthly)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="enrollmentChart" style="max-height: 150px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded-4 border-0 h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Monthly Revenue (LKR)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="max-height: 150px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Count-Up Animation
    document.querySelectorAll('.count').forEach(counter => {
        const target = +counter.getAttribute('data-count');
        let count = 0;
        const step = target / 40;

        const updateCount = () => {
            count += step;
            if(count < target) {
                counter.innerText = Math.ceil(count);
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    // Enrollment Chart Data
    const enrollmentLabels = @json($studentEnrollments['labels']);
    const enrollmentBranches = @json($studentEnrollments['branches']);

    const colors = [
        'rgba(0, 123, 255, 0.8)',    // Blue
        'rgba(40, 167, 69, 0.8)',    // Green
        'rgba(255, 193, 7, 0.8)',    // Yellow
        'rgba(23, 162, 184, 0.8)',   // Teal
        'rgba(220, 53, 69, 0.8)',    // Red
        'rgba(111, 66, 193, 0.8)',   // Purple
    ];

    const enrollmentDatasets = Object.keys(enrollmentBranches).map((branch, index) => ({
        label: branch,
        data: enrollmentBranches[branch],
        borderColor: colors[index % colors.length],
        backgroundColor: colors[index % colors.length].replace('0.8', '0.3'),
        fill: true,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        hoverBorderWidth: 3,
    }));

    const ctxEnrollment = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(ctxEnrollment, {
        type: 'line',
        data: {
            labels: enrollmentLabels,
            datasets: enrollmentDatasets
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'nearest',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold',
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    },
                    title: {
                        display: true,
                        text: 'Number of Students',
                        font: {
                            size: 14,
                            weight: 'bold',
                        }
                    }
                },
                x: {
                    grid: {
                        color: '#f0f0f0'
                    }
                }
            }
        }
    });

    // Revenue Chart Data
    const revenueLabels = @json($studentEnrollments['labels']);
    const revenueData = @json($monthlyRevenue);

    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue (LKR)',
                data: revenueData,
                backgroundColor: 'rgba(40, 167, 69, 0.75)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1,
                borderRadius: 5,
                hoverBackgroundColor: 'rgba(23, 162, 184, 0.85)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => `LKR ${context.parsed.y.toLocaleString()}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f0f0f0'
                    },
                    title: {
                        display: true,
                        text: 'Revenue (LKR)',
                        font: {
                            size: 14,
                            weight: 'bold',
                        }
                    },
                    ticks: {
                        callback: value => value.toLocaleString()
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection

