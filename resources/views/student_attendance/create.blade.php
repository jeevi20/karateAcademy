@extends('layouts.admin.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Record Student Attendance</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student_attendance.store') }}" method="POST">
        @csrf

        <!-- Attendance Type Selector -->
        <div class="form-group mb-3">
            <label>Attendance Type</label><br>
            <input type="radio" name="attendance_type" value="class" id="type_class" checked>
            <label for="type_class" class="me-3">Class</label>
            <input type="radio" name="attendance_type" value="event" id="type_event">
            <label for="type_event">Event</label>
        </div>

        <!-- Class Dropdown -->
        <div id="class_section">
            <div class="form-group mb-3">
                <label for="karate_class_template_id">Class Name</label>
                <select name="karate_class_template_id" id="karate_class_template_id" class="form-control">
                    <option value="" disabled selected>-- Select Class --</option>
                    @foreach($karateClassTemplates as $template)
                        <option value="{{ $template->id }}">{{ $template->class_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3" id="schedule_div" style="display: none;">
                <label for="schedule_id">Schedule</label>
                <select name="schedule_id" id="schedule_id" class="form-control">
                    <option value="" disabled selected>-- Select Schedule --</option>
                </select>
            </div>
        </div>

        <!-- Event Dropdown -->
        <div id="event_section" style="display: none;">
            <div class="form-group mb-3">
                <label for="event_id">Event Name</label>
                <select name="event_id" id="event_id" class="form-control">
                    <option value="" disabled selected>-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" >{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Student Attendance List -->
        <div class="form-group mb-3" id="student_attendance_div" style="display: none;">
            <label>Student Attendance</label>
            <div id="students-list"></div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function resetStudents() {
        $('#students-list').empty();
        $('#student_attendance_div').hide();
    }

    function loadStudents(students) {
        let studentsHtml = '';
        students.forEach(function (student) {
            studentsHtml += `
                <div class="form-check mb-2">
                    <strong>${student.name}</strong><br>
                    <input class="form-check-input" type="radio" name="attendance[${student.id}]" value="present" id="present_${student.id}">
                    <label class="form-check-label me-3" for="present_${student.id}">Present</label>
                    <input class="form-check-input" type="radio" name="attendance[${student.id}]" value="absent" id="absent_${student.id}">
                    <label class="form-check-label me-3" for="absent_${student.id}">Absent</label>
                    <input class="form-check-input" type="radio" name="attendance[${student.id}]" value="late" id="late_${student.id}">
                    <label class="form-check-label" for="late_${student.id}">Late</label>
                </div>
            `;
        });
        $('#students-list').html(studentsHtml);
        $('#student_attendance_div').show();
    }

    // Toggle sections based on attendance type
    $('input[name="attendance_type"]').change(function () {
        let selected = $(this).val();
        resetStudents();

        if (selected === 'class') {
            $('#class_section').show();
            $('#event_section').hide();
        } else {
            $('#class_section').hide();
            $('#event_section').show();
        }
    });

    // Load schedules for selected class
    $('#karate_class_template_id').change(function () {
        let classId = $(this).val();

        if (classId) {
            $.get('/attendances/get-schedules/' + classId, function (response) {
                $('#schedule_id').empty().append('<option value="" disabled selected>-- Select Schedule --</option>');
                response.schedules.forEach(schedule => {
                    $('#schedule_id').append(`<option value="${schedule.id}">${schedule.schedule_date}</option>`);
                });
                $('#schedule_div').show();
                resetStudents();
            }).fail(function () {
                alert('Error loading schedules');
                $('#schedule_div').hide();
            });
        }
    });

    // Load students for selected schedule
    $('#schedule_id').change(function () {
        let scheduleId = $(this).val();
        if (scheduleId) {
            $.get('/attendances/get-students/' + scheduleId, function (response) {
                loadStudents(response.students);
            }).fail(function () {
                alert('Error loading students');
                resetStudents();
            });
        }
    });

    // Load students for selected event
    $('#event_id').change(function () {
        let eventId = $(this).val();
        let eventType = $('#event_id option:selected').data('type');

        if (eventId) {
            let url = eventType === 'grading_exam'
                ? '/attendances/get-registered-students/' + eventId
                : '/attendances/get-all-students-for-event/' + eventId;

            $.get(url, function (response) {
                loadStudents(response.students);
            }).fail(function () {
                alert('Error loading students for event');
                resetStudents();
            });
        }
    });
});
</script>
@endsection




