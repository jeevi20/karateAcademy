@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Edit Schedule</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Select Class -->
                        <div class="form-group">
                            <label for="karate_class_template_id">Select Class</label>
                            <select name="karate_class_template_id" id="karate_class_template_id" class="form-control" required>
                                <option value="" disabled>-- Select Class --</option>
                                @foreach($karateClassTemplates as $class)
                                    <option value="{{ $class->id }}" {{ $schedule->karate_class_template_id == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Branch -->
                        <div class="form-group">
                            <label for="branch_id">Select Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control" required>
                                <option value="" disabled selected>-- Select Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $schedule->branch_id == $branch->id ? 'selected' : ''}}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Instructor -->
                        <div class="form-group">
                            <label for="instructor_id">Select Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-control">
                                <option value="" {{ $schedule->instructor_id == null ? 'selected' : '' }}>-- Optional --</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ $schedule->instructor_id == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }} {{ $instructor->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Schedule Date -->
                        <div class="form-group">
                            <label for="schedule_date">Schedule Date</label>
                            <input type="date" name="schedule_date" id="schedule_date" class="form-control" value="{{ $schedule->schedule_date }}" required>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="scheduled" {{ $schedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="canceled" {{ $schedule->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="{{ route('schedule.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
