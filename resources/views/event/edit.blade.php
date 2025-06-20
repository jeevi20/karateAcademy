@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">
    <h2>Edit Event</h2>     
    <br>

    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">
            <!-- Event Title -->
            <div class="form-group col-md-4">
                <label for="title">Event Title</label>
                <input type="text" name="title" class="form-control rounded" id="title" value="{{ old('title', $event->title) }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Event Type -->
            <div class="form-group col-md-4">
                <label for="event_type">Event Type</label>
                <select name="event_type" id="event_type" class="form-control rounded" required>
                    <option value="">Select Event Type</option>
                    <option value="class" {{ old('event_type', $event->event_type) == 'class' ? 'selected' : '' }}>Class</option>
                    <option value="tournament" {{ old('event_type', $event->event_type) == 'tournament' ? 'selected' : '' }}>Tournament</option>
                    <option value="seminar" {{ old('event_type', $event->event_type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="grading exams" {{ old('event_type', $event->event_type) == 'grading exams' ? 'selected' : '' }}>Grading Exam</option>
                    <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('event_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Event Date -->
            <div class="form-group col-md-4">
                <label for="event_date">Event Date</label>
                <input type="date" name="event_date" class="form-control rounded" id="event_date" value="{{ old('event_date', $event->event_date) }}" required>
                @error('event_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            
            <!-- Start Time -->
            <div class="form-group col-md-4">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" class="form-control rounded" id="start_time" 
                    value="{{ old('start_time', isset($event->start_time) ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '') }}" required>
                @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- End Time -->
            <div class="form-group col-md-4">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" class="form-control rounded" id="end_time" 
                    value="{{ old('end_time', isset($event->end_time) ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '') }}">
                @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Location -->
            <div class="form-group col-md-4">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control rounded" id="location" value="{{ old('location', $event->location) }}" required>
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Event Type -->
            <div class="form-group col-md-4">
                <label for="event_type">Event Type</label>
                <select name="event_type" id="event_type" class="form-control rounded" required>
                    <option value="">Select Event Type</option>
                    <option value="tournament" {{ old('event_type', $event->event_type) == 'tournament' ? 'selected' : '' }}>Tournament</option>
                    <option value="seminar" {{ old('event_type', $event->event_type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="grading exams" {{ old('event_type', $event->event_type) == 'grading exams' ? 'selected' : '' }}>Grading Exam</option>
                    <option value="other" {{ old('event_type', $event->event_type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('event_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>


            <!-- Description -->
            <div class="form-group col-md-4">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control rounded" rows="2">{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3">Update</button>

        </fieldset>
    </form>
</div>

@endsection
