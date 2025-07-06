@extends('layouts.admin.master')
@section('title', 'Create Grading Exam Result')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Create Grading Exam Result</h2>
            </div>

            <div class="card-body">
                <form action="{{ route('grading_exam_result.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="exam">Select Grading Exam:</label>
                        <select name="examId" id="exam" class="form-control" required>
                            <option value="">Select Exam</option>
                            @foreach ($gradingExams as $exam)
                                <option value="{{ $exam->id }}" {{ isset($examId) && $examId == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="student_id">Student</label>
                        <select name="student_id" class="form-control" required>
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name ?? '?' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="result">Result</label>
                        <select name="result" class="form-control" required>
                            <option value="">Select Result</option>
                            <option value="fail">Fail</option>
                            <option value="pass">Pass</option>
                            <option value="good_pass">Good Pass</option>
                            <option value="merit_pass">Merit Pass</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Result</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
