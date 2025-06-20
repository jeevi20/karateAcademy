@extends('layouts.admin.master')
@section('title', 'Edit Student Attendance')
@section('content')

<div class="col-md-12">
    <h2>Edit Student Attendance</h2>
    <br>

    <form action="{{ route('student_attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">

            <!-- Attendance Type -->
            <div class="form-group col-md-4">
                <label>Attendance Type</label><br>
                <input type="radio" name="attendance_type" value="class" id="type_class" 
                    {{ $attendanceType === 'class' ? 'checked' : '' }}>
                <label for="type_class" class="me-3">Class</label>

                <input type="radio" name="attendance_type" value="event" id="type_event" 
                    {{ $attendanceType === 'event' ? 'checked' : '' }}>
                <label for="type_event">Event</label>
            </div>

            <!-- Class Section -->
            <div id="class_section" style="{{ $attendanceType === 'class' ? '' : 'display:none;' }}">
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
            </div>

            <!-- Event Section -->
            <div id="event_section" style="{{ $attendanceType === 'event' ? '' : 'display:none;' }}">
                <div class="form-group col-md-4">
                    <label for="event_id">Event</label>
                    <select name="event_id" id="event_id" class="form-control">
                        <option value="">-- Select Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" 
                                {{ old('event_id', $attendance->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} 
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Student -->
            <div class="form-group col-md-4">
                <label for="student_id">Student</label>
                <select name="student_id" id="student_id" class="form-control">
                    <option value="">-- Select Student --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ old('student_id', $attendance->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
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
                <a href="{{ route('student_attendance.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </div>

        </fieldset>
    </form>

</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        function toggleSections() {
            const type = $('input[name="attendance_type"]:checked').val();
            if (type === 'class') {
                $('#class_section').show();
                $('#event_section').hide();
            } else {
                $('#class_section').hide();
                $('#event_section').show();
            }
        }

        toggleSections();

        $('input[name="attendance_type"]').on('change', toggleSections);

        $('#karate_class_template_id').on('change', function () {
            const classId = $(this).val();
            if (classId) {
                $.get(`/attendances/get-schedules/${classId}`, function (data) {
                    const $scheduleSelect = $('#schedule_id');
                    $scheduleSelect.empty().append('<option value="">-- Select Schedule --</option>');
                    data.forEach(schedule => {
                        $scheduleSelect.append(`<option value="${schedule.id}">${schedule.day} ${schedule.start_time} - ${schedule.end_time}</option>`);
                    });
                });
            }
        });
    });
</script>
@endsection

