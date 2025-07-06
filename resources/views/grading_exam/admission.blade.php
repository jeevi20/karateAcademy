@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h1 class="mb-4">Grading Exam Admissions</h1>

    
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @foreach ($gradingExams as $exam)
    <h3>{{ $exam->title }}</h3>

    <br>
    
    <form action="{{ route('grading_exam.releaseAll') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="event_id" value="{{ $exam->id }}">
        <button type="submit" class="btn btn-success">
            Release Admissions
        </button>
    </form>

    <br><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Action</th>
                <th>Admission released status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($exam->students as $student)
                <tr>
                    <td>{{ $student->name ?? 'No user assigned' }} {{ $student->last_name ?? '' }}</td>
                    
                    <td>
                        <!-- <a href="{{ route('grading_exam.admission_card.view', ['exam' => $exam->id, 'student' => $student->id]) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                            <i class="fa fa-eye"></i>
                        </a> -->
                        <a href="{{ route('grading_exam.admission_card.download', ['exam' => $exam->id, 'student' => $student->id]) }}" class="btn btn-light btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Download">
                            <i class="fa fa-download"> </i>
                        </a>

                    </td>

                    <td>
                        <span class="badge bg-{{ $student->pivot->released ? 'danger' : 'success' }}">
                            {{ $student->pivot->is_admission_released ? 'Released' : 'Not Released' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No students assigned to this exam.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endforeach

    
    
    
</div>
@endsection

