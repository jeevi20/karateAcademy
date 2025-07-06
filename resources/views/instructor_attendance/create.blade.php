@extends('layouts.admin.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Record Instructor Attendance</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('instructor_attendance.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="karate_class_template_id">Class Name</label>
            <select name="karate_class_template_id" id="karate_class_template_id" class="form-control" required>
                <option value="" disabled selected>-- Select Class --</option>
                @foreach($karateClassTemplates as $template)
                    <option value="{{ $template->id }}">{{ $template->class_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3" id="schedule_div" style="display: none;">
            <label for="schedule_id">Schedule</label>
            <select name="schedule_id" id="schedule_id" class="form-control" required>
                <option value="" disabled selected>-- Select Schedule --</option>
            </select>
        </div>

        <div class="form-group mb-3" id="instructor_attendance_div" style="display: none;">
            <label>Instructor Attendance</label>
            <div id="instructors-list"></div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
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
