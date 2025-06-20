@extends('layouts.admin.master')
@section('content')

<!-- Begin Page Content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Grading Exams</h1>
            </div>

            <br>
            <div class="row px-4 pb-4">
                <!-- Admissions Card -->
                <div class="col-md-4 col-sm-12 mb-4"> 
                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                <img src="https://cdn.vectorstock.com/i/500p/33/12/red-color-inserted-label-with-word-admission-vector-55483312.jpg" alt="Admissions" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h5 class="card-title mt-3"></h5>
                            <p class="card-text"><a href="{{ route('grading_exam.admission') }}">Admissions</a></p>
                        </div>
                    </div>
                </div>

                <!-- Exam Details Card -->
                <div class="col-md-4 col-sm-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                <img src="https://cdn-icons-png.flaticon.com/256/11776/11776326.png" alt="Exam Details" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h5 class="card-title mt-3"></h5>
                            <p class="card-text">
                                <a href="{{ route('grading_exam.detail') }}" >Exam Details</a>
                            </p>
                        </div>
                    </div>
                </div>


                <!-- Results Card -->
                <div class="col-md-4 col-sm-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                <img src="https://png.pngtree.com/png-vector/20220912/ourmid/pngtree-vector-results-note-reminder-red-text-vector-png-image_14498790.png" alt="Results" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h5 class="card-title mt-3"></h5>
                            <p class="card-text"><a href="{{ route('grading_exam_result.index') }}">Results</a></p>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
<!-- End Page Content -->

@endsection
