@extends('layouts.admin.master')

@section('content')
<!-- Begin Page Content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Attendances</h1>

                <div class="dropdown">
                    <button class="btn btn-outline-primary me-2" type="button" id="reportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fas fa-chart-line"></i> Report
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="reportDropdown">
                        <li><a class="dropdown-item" href="{{ route('student_attendance.monthly_report') }}">Student</a></li>
                        <li><a class="dropdown-item" href="">Instructor</a></li>
                    </ul>
                </div>
            </div>


            <div class="row p-3">
                <!-- Student Attendances Card -->
                <div class="col-md-4 col-sm-12 mb-4"> 
                    <a href="{{ route('student_attendance.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="Students" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <h5 class="card-title mt-3">Students</h5>
                                <p class="card-text">Student Attendances</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Instructor Attendances Card -->
                <div class="col-md-4 col-sm-12 mb-4">
                    <a href="{{ route('instructor_attendance.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                    <img src="https://pngimg.com/d/karate_PNG87.png" alt="Instructors" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <h5 class="card-title mt-3">Instructors</h5>
                                <p class="card-text">Instructor Attendances</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 
        </div> 
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endsection

