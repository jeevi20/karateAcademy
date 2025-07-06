@extends('layouts.admin.master')

@section('content')
<div class="container">
    <h4 class="text-center my-4">Total Student Payments by Branch - {{ $year }}</h4>

    <form method="GET" class="mb-4" id="filter-form">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="form-check mb-2">
                <input type="checkbox" name="enable_year" id="enable_year" class="form-check-input" {{ request('enable_year') ? 'checked' : '' }}>
                <label for="enable_year" class="form-check-label">Filter by Year</label>
            </div>

            <select name="year" id="year_select" class="form-control" {{ request('enable_year') ? '' : 'disabled' }}>
                @for ($i = now()->year; $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary me-2">Filter</button>
        <a href="{{ route('payment.annual_report_print', request()->query()) }}"
   target="_blank"
   class="btn btn-outline-secondary">
    Print
</a>
    </div>
</form>

    <table class="table table-bordered mt-4">
        
        <tr>
            <th>Total Student Payments for {{ $year }}</th>
            <th>Rs. {{ number_format($totalPaid, 2) }}</th>
        </tr>
    
    </table>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('enable_year');
        const yearSelect = document.getElementById('year_select');

        checkbox.addEventListener('change', function () {
            yearSelect.disabled = !checkbox.checked;
        });
    });
</script>
@endsection
