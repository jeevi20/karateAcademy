@extends('layouts.admin.master')
@section('title','Staffs Salary Record')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="float-left">
                    <h2> Salary Record </h2>
                </div>

                <div class="float-right">
                    <!-- back to dashboard -->
                    <a href="{{ route('dashboard') }}" class="btn btn-dark" >Back</a>

                    
                </div>
            </div>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            <div class="card-body">

                
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
