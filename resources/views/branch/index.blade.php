@extends('layouts.admin.master')
@section('content')

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Branches</h2>

                <div>
                    <!-- Back to Dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-dark">Back</a>
                    
                    <!-- Add Branch Button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('branch.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> 
                        <i class='fas fa-plus' style="color:white"></i> Add
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @foreach ($branches as $branch)
                        <div class="col-md-4 col-sm-12 mb-4">
                            <div class="card border-secondary mb-3 shadow" style="max-width: 18rem;">
                                <div class="card-header text-center">
                                    <a href="{{ route('branch.show', $branch->id) }}" class="text-decoration-none text-dark fw-bold">
                                        <h6>{{ $branch->branch_name }} ({{ $branch->branch_code }}) </h6>
                                    </a>
                                </div>
                                <div class="card-body text-secondary text-center">
                                    <h4 class="card-title">Students - {{ $branch->students->count() }}</h4>
                                    <h4 class="card-title mt-3">Instructors - {{ $branch->instructors->count() }}</h4>

                                    <!-- Report Button -->
                                    <a href="{{ route('branch.report', $branch->id) }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-download"></i> Report
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> <!-- End row -->
            </div> <!-- End card-body -->
        </div>
    </div>
</div>

@endsection
