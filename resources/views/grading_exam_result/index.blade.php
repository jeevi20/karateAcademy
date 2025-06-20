@extends('layouts.admin.master')
@section('title', 'Students Result Record')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Results</h2>

                <div class="d-flex align-items-center gap-2">
                    <div style="width: 300px;">
                        <select id="selectExam" class="form-control">
                            <option value="">Select Grading Exam</option>
                            @foreach ($gradingExams as $event)
                                <option value="{{ route('grading_exam_result.create', ['examId' => $event->id]) }}"
                                    @if (isset($examId) && $examId == $event->id) selected @endif>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button id="createResultBtn" class="btn btn-primary">Create Result</button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body">
                <table id="myTable" class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Applied Belt</th>
                            <th>Result</th>
                            <th>Recorded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td>{{ $result->student->name ?? '-' }}</td>
                            <td>
                                @php
                                    $belt = $result->event->students()
                                        ->where('users.id', $result->student_id)
                                        ->first()?->pivot?->belt_want_to_receive;
                                @endphp
                                {{ optional(optional($belt)->belt)->name ?? '-' }}
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $result->result)) }}</td>
                            <td>{{ $result->instructor->name ?? '-' }}</td>
                            <td>
                                <a href="" class="btn btn-warning btn-sm">Edit</a>
                                <form action="" method="POST" class="d-inline" onsubmit="return confirm('Delete this result?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();

        $('#selectExam').select2({
            placeholder: 'Select Grading Exam',
            allowClear: true
        });

        // Redirect on exam selection
        $('#selectExam').on('change', function () {
            var url = $(this).val();
            if (url) {
                window.location.href = url;
            }
        });

        // Create Result Button Logic
        $('#createResultBtn').on('click', function () {
            var url = $('#selectExam').val();
            if (url) {
                window.location.href = url;
            } else {
                alert('Please select a grading exam first.');
            }
        });
    });
</script>
@endsection
