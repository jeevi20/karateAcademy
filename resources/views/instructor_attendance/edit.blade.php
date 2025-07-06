@extends('layouts.admin.master')
@section('title', 'Edit Instructor Attendance')
@section('content')

<div class="col-md-12">
    <h2>Edit Instructor Attendance</h2>
    <br>

    <form action="{{ route('instructor_attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">

            
            <!-- Class Section -->
            
                <div class="form-group col-md-4">
                    <label for="karate_class_template_id">Class</label>
                    <select name="karate_class_template_id" id="karate_class_template_id" class="form-control">
                        <option value="">-- Select Class --</option>
                        @foreach ($karateClassTemplates as $class)
                            <option value="{{ $class->id }}" 
                                {{ old('karate_class_template_id', $attendance->schedule?->karate_class_template_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="schedule_id">Schedule</label>
                    <select name="schedule_id" id="schedule_id" class="form-control">
                        <option value="">-- Select Schedule --</option>
                        @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->id }}" 
                                {{ old('schedule_id', $attendance->schedule_id) == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->schedule_date }} 
                            </option>
                        @endforeach
                    </select>
                </div>
        


            <!-- Status -->
            <div class="form-group col-md-4">
                <label for="status">Attendance Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                </select>
            </div>

            <!-- Date -->
            <div class="form-group col-md-4">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" class="form-control" 
                    value="{{ old('date', $attendance->date) }}" required>
            </div>

            <br>
            <div>
                <button type="submit" class="btn btn-success">Update Attendance</button>
                <a href="{{ route('instructor_attendance.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </div>

        </fieldset>
    </form>

</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function resetInstructors() {
        $('#instructors-list').empty();
        $('#instructor_attendance_div').hide();
    }

    function loadInstructors(instructors) {
        let instructorsHtml = '';
        instructors.forEach(function (instructor) {
            instructorsHtml += `
                <div class="form-check mb-2 d-flex align-items-center">
                    <strong class="me-3">${instructor.name}</strong>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="attendance[${instructor.id}]" value="present" id="present_${instructor.id}" required>
                        <label class="form-check-label" for="present_${instructor.id}">Present</label>
                    </div>
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="attendance[${instructor.id}]" value="absent" id="absent_${instructor.id}">
                        <label class="form-check-label" for="absent_${instructor.id}">Absent</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attendance[${instructor.id}]" value="late" id="late_${instructor.id}">
                        <label class="form-check-label" for="late_${instructor.id}">Late</label>
                    </div>
                </div>

            `;
        });
        $('#instructors-list').html(instructorsHtml);
        $('#instructor_attendance_div').show();
    }

    // Load schedules when class is selected
    $('#karate_class_template_id').change(function () {
        const classId = $(this).val();
        resetInstructors();

        if (classId) {
            $.get('/attendances/get-instructor-schedules/' + classId, function (response) {
                $('#schedule_id').empty().append('<option value="" disabled selected>-- Select Schedule --</option>');
                response.schedules.forEach(schedule => {
                    $('#schedule_id').append(`<option value="${schedule.id}">${schedule.schedule_date}</option>`);
                });
                $('#schedule_div').show();
            }).fail(function () {
                alert('Error loading schedules.');
                $('#schedule_div').hide();
            });
        }
    });

    // Load instructors for the selected schedule
    $('#schedule_id').change(function () {
        const scheduleId = $(this).val();
        resetInstructors();

        if (scheduleId) {
            $.get('/attendances/get-instructors/' + scheduleId, function (response) {
                loadInstructors(response.instructors);
            }).fail(function () {
                alert('Error loading instructors.');
            });
        }
    });
});
</script>
@endsection


