@extends('layouts.admin.master')
@section('content')

<div class="container">
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h2>Create New Class Template</h2>
            </div>

            <div class="card-body">
                <form action="{{route('class_template.store')}}" method="POST">
                    @csrf

                    <!-- Class Name -->
                    <div class="form-group">
                        <label for="class_name">Class Name</label>
                        <input type="text" name="class_name" class="form-control" id="class_name" required>
                    </div>


                    <!-- Start Time -->
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" name="start_time" class="form-control" id="start_time" required>
                    </div>

                    <!-- End Time -->
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" name="end_time" class="form-control" id="end_time" required>
                    </div>

                    <!-- Day -->
                    <div class="form-group">
                        <label for="day">Day</label>
                        <select name="day" class="form-control" id="day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success mt-3">Create</button>
                    <a href="{{ route('schedule.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->
@endsection
