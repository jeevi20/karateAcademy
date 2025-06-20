@extends('layouts.admin.master')
@section('content')

<!-- Begin Page Content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Karate Classes</h1>
            </div>

            <div class="row">
                <!-- Total Classes Card -->
                <div class="col-md-4 col-sm-12 mb-4"> 
                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                <img src="https://www.clipartmax.com/png/middle/197-1977305_class-icon-png-training-icon.png" alt="Total Classes" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <!-- Display total class count -->
                            <h5 class="card-title mt-3"></h5>
                            <p class="card-text">Total Classes - {{ $totalClasses }}</p>
                        </div>
                    </div>
                </div>

                <!-- Schedules Card -->
                <div class="col-md-4 col-sm-12 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                <img src="https://i.pinimg.com/736x/3b/4e/c1/3b4ec12161f833b3815d4289b272c7c2.jpg" alt="Schedules" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h5 class="card-title mt-3"></h5>
                            <p class="card-text"> <a href="{{ route('schedule.index') }}"> Schedules </a> </p>
                        </div>
                    </div>
                </div>

                <!-- Class Templets Card -->
                <div class="col-md-4 col-sm-12 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle mx-auto" style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                 <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Schedule_or_Calendar_Flat_Icon.svg/1024px-Schedule_or_Calendar_Flat_Icon.svg.png" alt="Class Templates" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <h5 class="card-title mt-3"></h5>
                                <p class="card-text"> <a href="{{ route('class_template.index') }}"> Class Templets </a> </p>
                            </div>
                        </div>
                    
                </div>
        </div>


            


            <!-- Class Details Section -->
            <!-- <div class="card mt-4">
                <div class="card-header">
                    <h2>Class Details</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Class Name</th>
                                <th>Branch</th>
                                <th>Time</th>
                                <th>Day</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $key => $class)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $class->class_name }}</td>
                                <td></td>
                                <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                                <td>{{ $class->day }}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> -->
            <!-- </div>

        </div> -->
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
