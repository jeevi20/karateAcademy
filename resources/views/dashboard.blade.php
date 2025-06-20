@extends('layouts.admin.master')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Card -->
    <div class="card">
        <div class="card-body">
            <h1>Dashboard</h1>
        </div>
    </div>

    <!-- Dashboard Content with Announcements -->
    <div class="row mt-4">
        <!-- Main Content (8 columns) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    
                        <p>Welcome to the dashboard!</p>
                    
                </div>
            </div>
        </div>

        <!-- Announcements Section (4 columns, aligned to the right) -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-white text-center" style="background-color: #524373;">
                    <h5 class="mb-0">📢 Latest Announcements</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if(isset($announcements) && $announcements->isNotEmpty())
                        <ul class="list-group">
                            @foreach($announcements as $announcement)
                                <li class="list-group-item">
                                    <h6 class="font-weight-bold text-primary">{{ $announcement->title }}</h6>
                                    <p class="text-muted mb-1">
                                        🗓 Announced on: <strong>{{ date('F j, Y', strtotime($announcement->announcement_date)) }}</strong>
                                    </p>
                                    <p class="text-dark mt-2">{{ Str::limit($announcement->body, 100) }}</p>

                                    @if($announcement->image)
                                        <div class="text-center my-2">
                                            <a href="{{ asset('storage/' . $announcement->image) }}" download="{{ basename($announcement->image) }}">
                                                <img src="{{ asset('storage/' . $announcement->image) }}" 
                                                     alt="Announcement Image" 
                                                     class="zoom-img img-thumbnail rounded" 
                                                     width="100">
                                            </a>
                                        </div>
                                    @endif

                                    <div class="text-right">
                                        <a href="{{ route('announcement.show', $announcement->id) }}" class="btn btn-info btn-sm">
                                            👀 View
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted">No announcements available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
