@extends('layouts.admin.master')
@section('title', 'Payment Details')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h2>Payment Details</h2>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th> ID </th>
                            <td> {{ $payment->id }} </td>
                        </tr>
                        <tr>
                            <th> Student Name</th>
                            <td> {{ $payment->student->name }} </td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>{{ $payment->student->branch->branch_name }}</td>
                        </tr>
                        <tr>
                            <th>Reference No</th>
                            <td>{{$payment->reference_no}}</td>
                        </tr>
                        <tr>
                            <th>Payment Category</th>
                            <td>{{ $payment->payment_category }}</td>
                        </tr>
                        <tr>
                            <th>Amount Received</th>
                            <td>Rs.{{ number_format($payment->amount, 2)}}</td>
                        </tr>
                        <tr>
                            <th>Date Received</th>
                            <td>{{ $payment->date_paid }}</td>
                        </tr>
                        <tr>
                            <th>Recorded By</th>
                            <td>{{ $payment->createdBy->name }}</td> <!-- Display the user who recorded the payment -->
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $payment->notes }} </td>
                        </tr>
                    </table>
                </div>

                <a href="{{ route('payment.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-warning">Edit</a>

            </div>
        </div>
    </div>
</div>

@endsection
