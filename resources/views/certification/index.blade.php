@extends('layouts.admin.master')
@section('title','Certification List')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Certifications</h2>
                
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-dark">Back</a>
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('certification.create') }}">
                        <i class="fas fa-plus" style="color:white"></i> Add
                    </a>
                </div>
            </div>
            <br>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <table id="myTable" class="display table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Type</th>
                            <th>Issued Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certifications as $cert)
                        <tr>
                            <td>{{ $cert->id }}</td>
                            <td>{{ $cert->user->name }}</td>
                            <td>{{ ucfirst($cert->certification_type) }}</td>
                            <td>{{ \Carbon\Carbon::parse($cert->issued_date)->format('M d, Y') }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="" class="btn btn-success btn-sm rounded-0" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- Download PDF -->
                                <a href="{{ route('certification.download', $cert->id) }}" class="btn btn-primary btn-sm rounded-0" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- card-body -->
        </div> <!-- card -->
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
@endsection

