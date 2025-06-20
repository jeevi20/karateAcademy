@extends('layouts.admin.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Event Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $event->id }}</td>
                        </tr>
                        <tr>
                            <th>Event Name</th>
                            <td>{{ $event->title }}</td>
                        </tr>
                        <tr>
                            <th>Event Date</th>
                            <td>{{ $event->event_date }}</td>
                        </tr>
                       
                        <tr>
                            <th>Location</th>
                            <td>{{ $event->location }}</td>
                        </tr>
                        <tr>
                            <th>Start Time</th>
                            <td>{{ $event->start_time}}</td>
                        </tr>
                        <tr>
                            <th>End Time</th>
                            <td>{{ $event->end_time ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $event->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($event->status) }}</td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('event.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection
