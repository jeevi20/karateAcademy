@extends('layouts.admin.master')
@section('title', 'Students Payments Record')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="float-left">
                    <h2>Payments</h2>
                </div>

                <div class="float-right">
                    <a href="" class="btn btn-outline-primary me-2">
                            <i class="fas fa-chart-line"></i> Report
                    </a>
                    <!-- Back to dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-dark">Back</a>

                    <!-- Add Payment Button -->
                    <a class="btn btn-primary btn-md btn-rounded" href="{{ route('payment.create') }}">
                        <i class="mdi mdi-plus-circle mdi-18px"></i> <i class='fas fa-plus' style="color:white"></i> Add
                    </a>
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card-body">

                <table id="myTable" class="display">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Reference No</th>
                            <th>Payment Category</th>
                            <th>Amount Received</th>
                            <th>Date Received</th>
                            <th>Student Name</th>
                            
                            <th>Recorded By</th>
                            <th>Actions</th>
                        </tr>   
                    </thead>

                    <tbody>
                    @foreach ($payments as $payment) 
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->reference_no }}</td>
                            <td>{{ $payment->payment_category }}</td>
                            <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->date_paid }}</td>
                            <td>{{ $payment->student->name }}</td> 
                            
                            <td>{{ $payment->createdBy->name }}</td> 
                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('payment.show', $payment->id ) }}" class="btn btn-info btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <!-- Download Button -->
                                <a href="{{ route('payment.downloadReceipt', $payment->id) }}" class="btn btn-light btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Download">
                                    <i class="fa fa-download"> </i>
                                </a>
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

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

@endsection
