@extends('layouts.admin.master')
@section('title', 'Edit Grading Exam Result')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Edit Grading Exam Result</h2>
            </div>

            <div class="card-body">
                <form action="{{ route('grading_exam_result.update', $gradingExamResult->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- The exam dropdown -->
    <div class="form-group">
    <label for="exam">Select Grading Exam:</label>
    <input type="text" class="form-control" id="exam" value="{{ $gradingExamResult->gradingExam->title ?? '-' }}" readonly>
    </div>

    <!-- Student dropdown -->
    <div class="form-group">
        <label for="student_name" class="form-label">Student Name</label>
        <input type="text" class="form-control" id="student_name" value="{{ $gradingExamResult->student->name ?? '-' }}" readonly>

    </div>


    <!-- Result dropdown -->
     <div class="form-group">
    <label for="result">Result</label>
    <select name="result" class="form-control" required>
        <option value="">Select Result</option>
        <option value="fail" {{ ($gradingExamResult->result == 'fail') ? 'selected' : '' }}>Fail</option>
        <option value="pass" {{ ($gradingExamResult->result == 'pass') ? 'selected' : '' }}>Pass</option>
        <option value="good_pass" {{ ($gradingExamResult->result == 'good_pass') ? 'selected' : '' }}>Good Pass</option>
        <option value="merit_pass" {{ ($gradingExamResult->result == 'merit_pass') ? 'selected' : '' }}>Merit Pass</option>
    </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Result</button>
</form>

                   

                   
            </div>
        </div>
    </div>
</div>
@endsection
