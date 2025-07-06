@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">
    <h2>Schedule an Upcoming Event</h2>     
    <br>

    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset class="border p-4 mb-4">

            <div class="row">
                <!-- Event Title -->
                <div class="form-group col-md-6">
                    <label for="title">Event Title</label>
                    <input type="text" name="title" class="form-control rounded" id="title" required>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Event Type -->
                <div class="form-group col-md-6">
                    <label for="event_type">Event Type</label>
                    <select name="event_type" id="event_type" class="form-control rounded" required>
                        <option value="">Select Event Type</option>
                        <option value="tournament">Tournament</option>
                        <option value="seminar">Seminar</option>
                        <option value="grading exams">Grading Exam</option>
                        <option value="other">Other</option>
                    </select>
                    @error('event_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <!-- Event Date -->
                <div class="form-group col-md-6">
                    <label for="event_date">Event Date</label>
                    <input type="date" name="event_date" class="form-control rounded" id="event_date" required>
                    @error('event_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Start Time -->
                <div class="form-group col-md-6">
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" class="form-control rounded" id="start_time" required>
                    @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <!-- End Time -->
                <div class="form-group col-md-6">
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" class="form-control rounded" id="end_time">
                    @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    <span id="end_time_error" class="text-danger" style="display:none;">End time must be later than start time.</span>
                </div>

                <!-- Location -->
                <div class="form-group col-md-6">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control rounded" id="location" required>
                    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <!-- Description -->
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control rounded" rows="3"></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mt-3">Create</button>
            <a href="{{ route('event.index') }}" class="btn btn-secondary mt-3 ml-2">Cancel</a>

        </fieldset>
    </form>
</div>

<script>
    document.getElementById('end_time').addEventListener('input', function() {
        var startTime = document.getElementById('start_time').value;
        var endTime = document.getElementById('end_time').value;

        if (endTime && startTime && endTime <= startTime) {
            document.getElementById('end_time_error').style.display = 'inline';
            document.getElementById('end_time').setCustomValidity('End time must be later than start time.');
        } else {
            document.getElementById('end_time_error').style.display = 'none';
            document.getElementById('end_time').setCustomValidity('');
        }
    });
</script>

@endsection

