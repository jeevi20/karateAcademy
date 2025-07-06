@extends('layouts.admin.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header  text-white" style="background-color: #060b33;">
                <h3 class="mb-0">{{ $announcement->title }}</h3>
                <small class="text-light">
                   Published Date: {{ \Carbon\Carbon::parse($announcement->announcement_date)->format('F j, Y') }} &nbsp;&nbsp;
                </small>
                <br>
            </div>

            <div class="card-body">
                @if($announcement->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="Announcement Image" class="img-fluid rounded" style="max-height: 250px;">
                    </div>
                @endif

                <p style="white-space: pre-line; font-size: 1.1rem;">{!! nl2br(e($announcement->body)) !!}</p>

                @if(!empty($announcement->link))
                    <p>
                        <a href="{{ $announcement->link }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary">
                            Visit Related Link
                        </a>
                    </p>
                @endif
            </div>

            <!-- <div class="card-footer text-right">
                <a href="{{ route('announcement.index') }}" class="btn btn-secondary">Back to Announcements</a>
                <a href="{{ route('announcement.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>
            </div> -->
        </div>
    </div>
</div>

@endsection
