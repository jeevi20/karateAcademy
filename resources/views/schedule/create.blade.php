@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Create Schedule</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf

                        <!-- Select Class -->
                        <div class="form-group">
                            <label for="karate_class_template_id">Select Class</label>
                            <select name="karate_class_template_id" id="karate_class_template_id" class="form-control" required>
                                <option value="" disabled selected>-- Select Class --</option>
                                @foreach($karateClassTemplates as $template)
                                    <option value="{{ $template->id }}">{{ $template->class_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Branch -->
                        <div class="form-group">
                            <label for="branch_id">Select Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control" required>
                                <option value="" disabled selected>-- Select Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select Instructor -->
                        <div class="form-group">
                            <label for="instructor_id">Select Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-control">
                                <option value="" selected>-- Optional --</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }} {{ $instructor->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Schedule Date -->
                        <div class="form-group">
                            <label for="schedule_date">Schedule Date</label>
                            <input type="date" name="schedule_date" id="schedule_date" class="form-control" required>
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
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Calculate tomorrow's date
        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        // Format the date as yyyy-mm-dd
        var dd = String(tomorrow.getDate()).padStart(2, '0');
        var mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        var yyyy = tomorrow.getFullYear();
        var tomorrowFormatted = yyyy + '-' + mm + '-' + dd;

        // Set the min attribute to tomorrow's date
        $('#schedule_date').attr('min', tomorrowFormatted);
        
        @if($isWeekend)
            $('#schedule_date').on('change', function() {
                var selectedDate = new Date($(this).val());
                var dayOfWeek = selectedDate.getDay(); // Get day of the week (0 = Sunday, 6 = Saturday)

                // If the selected date is not Saturday (6) or Sunday (0), show an alert and clear the input.
                if (dayOfWeek !== 6 && dayOfWeek !== 0) {
                    alert("Please select a Saturday or Sunday.");
                    $(this).val(''); // Clear the invalid selection
                }
            });
        @endif
    });
</script>
@endsection

