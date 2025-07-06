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
                    <select id="selectExam" class="form-select form-select-sm" style="width: auto;">
                        <option value="">-- Select Grading Exam --</option>
                        @foreach ($gradingExams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                        @endforeach
                    </select>

                    <button id="createResultBtn" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i>Add
                    </button>
                </div>

            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body">

            @if (auth()->user()->role_id == 1)
                <form method="POST" action="{{ route('grading_exam_result.release') }}" class="d-flex align-items-center gap-2 mb-3">
                    @csrf
                    <select name="exam_id" class="form-select" required style="width: 250px;">
                        <option value="" disabled selected>Select Exam to Release</option>
                        @foreach ($gradingExams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->title }} ({{ \Carbon\Carbon::parse($exam->date)->format('Y-m-d') }})
                                @if (cache()->has('released_exam_' . $exam->id))
                                    <span class="badge bg-success">  Released</span>
                                @else
                                    <span class="badge bg-warning"> Not Released </span>
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success btn-sm">Release</button>
                </form>
            @endif

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
                            <td>{{ $result->belt_name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $result->result ?? '')) }}</td>
                            <td>{{ $result->instructor->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('grading_exam_result.edit', $result->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                @if (auth()->user()->role_id == 1)
                                    <form id="deleteForm-{{ $result->id }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $result->id }})">Delete</button>
                                @else
                                    <button class="btn btn-secondary btn-sm d-none" onclick="cannotDeleteAlert()">Delete</button>

                                @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function confirmDelete(gradingExamResultId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This will delete this grading exam result.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let deleteForm = document.getElementById("deleteForm-" + gradingExamResultId);
                deleteForm.action = `/grading-exams/results/${gradingExamResultId}/destroy`;
                deleteForm.submit();
            }
        });
    }
</script>

   <script>
    document.getElementById('createResultBtn').addEventListener('click', function () {
        const examId = document.getElementById('selectExam').value;
        if (examId) {
            window.location.href = `/grading-exams/create?examId=${examId}`;
        } else {
            alert('Please select a grading exam first.');
        }
    });
</script>
 

   

  



@endsection
