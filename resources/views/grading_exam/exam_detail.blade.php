@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Select Grading Exam</h1>

    <!-- Exam Dropdown -->
    <form method="GET" action="{{ route('grading_exam.detail') }}">
        <div class="form-group">
            <label for="exam">Select Grading Exam:</label>
            <select name="examId" id="exam" class="form-control" onchange="this.form.submit()">
                <option value="">Select Exam</option>
                @foreach ($gradingExams as $exam)
                    <option value="{{ $exam->id }}" {{ request('examId') == $exam->id ? 'selected' : '' }}>
                        {{ $exam->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(request('examId'))
        @php
            $exam = App\Models\Event::find(request('examId'));
        @endphp

        @if($exam)
            <div class="mt-4">
                <h3>{{ $exam->title }}</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Student List</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $exam->title }}</td>
                            <td>{{ $exam->location }}</td>
                            <td>{{ \Carbon\Carbon::parse($exam->event_date)->format('F j, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($exam->exam_time)->format('h:i A') }}</td>
                            <td>
                                @if($exam->students && count($exam->students) > 0)
                                    <ul>
                                        @foreach ($exam->students as $student)
                                            <li>{{ $student->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No students registered.
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p>No exam found with the selected ID.</p>
        @endif
    @else
        <p>Please select an exam to view its details.</p>
    @endif
</div>
@endsection
