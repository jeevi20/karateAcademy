@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Grading Exam Admissions</h1>

    @foreach ($gradingExams as $exam)
        <h3>{{ $exam->title }}</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($exam->students as $student)
                    <tr>
                        <td>{{ $student->name ?? 'No user assigned' }} {{ $student->last_name ?? 'No user assigned' }}</td>
                        <td>
                            <a href="{{ route('grading_exam.admission_card.view', ['exam' => $exam->id, 'student' => $student->id]) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('grading_exam.admission_card.download', ['exam' => $exam->id, 'student' => $student->id]) }}" class="btn btn-success ms-2">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No students assigned to this exam.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
</div>
@endsection

