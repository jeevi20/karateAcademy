@extends('layouts.admin.master')
@section('title', 'Add Certification')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Add Certification</h4>
                
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('certification.store') }}" method="POST">
                    @csrf

                    <!-- Student -->
                    <div class="form-group mb-3">
                        <label for="user_id">Student</label>
                        <select name="user_id" class="form-control" required>
                            <option value="" disabled selected>Select a student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->student->student_reg_no }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Certification Type -->
                    <div class="form-group mb-3">
                        <label for="certification_type">Certification Type</label>
                        <select name="certification_type" class="form-control" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="tournement" {{ old('certification_type') == 'tournement' ? 'selected' : '' }}>Tournement</option>
                            <option value="seminar" {{ old('certification_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="grading" {{ old('certification_type') == 'grading' ? 'selected' : '' }}>Grading</option>
                            <option value="belt" {{ old('certification_type') == 'belt' ? 'selected' : '' }}>Belt</option>
                        </select>
                    </div>

                    <!-- Issued Date -->
                    <div class="form-group mb-4">
                        <label for="issued_date">Issued Date</label>
                        <input type="date" name="issued_date" class="form-control" value="{{ old('issued_date') }}" required>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Save </button>
                    <a href="{{ route('certification.index') }}" class="btn btn-dark">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
