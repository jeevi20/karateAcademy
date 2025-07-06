@extends('layouts.admin.master')

@section('title', 'Student Enrollment Report')

@section('content')
<div class="container-fluid px-4 position-relative">

    
    <h2> Student Enrollment Report</h2>

    <br><br><br>
    <div>
    <!-- Filter Form -->
    <form method="GET" class="row g-2 mb-4 no-print">
        <div class="col-md-3">
            <label for="month" class="form-label">Filter by Month</label>
            <input type="month" id="month" name="month" class="form-control" value="{{ request('month') }}">
        </div>

        <div class="col-md-2 align-self-end">
            <button type="button" id="printBtn" class="btn btn-primary w-100">Print</button>
        </div>

    </form>
</div>
    
@endsection

@section('js')
<script>
    document.getElementById('printBtn').addEventListener('click', function() {
        const month = document.getElementById('month').value;
        let url = '{{ route("student.enrollment_report_print") }}';
        if (month) {
            url += '?month=' + encodeURIComponent(month);
        }
        window.open(url, '_blank');
    });
</script>

@endsection
