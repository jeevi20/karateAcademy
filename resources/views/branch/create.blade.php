@extends('layouts.admin.master')
@section('content')
       
<div class="col-md-12">

    <h1>Branch Registration Form</h1>     
    <br>

    <form method="POST" action="{{ route('branch.store') }}" enctype="multipart/form-data">
        @csrf

        <fieldset class="border p-4 mb-4">
        <legend class="w-auto px-2"></legend>

        <!--branch name feild-->
        <div class="form-group">
            <label for="branch_name">Branch Name</label>
            <input type="text" name="branch_name" class="form-control rounded" id="branch_name" >
            @error('branch_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--branch address feild-->
         <div class="form-group">
            <label for="branch_address">Branch Address</label>
            <input type="text" name="branch_address" class="form-control rounded" id="branch_address">
            @error('branch_address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--branch phone number feild-->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control rounded" id="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--branch phone number feild-->
        <div class="form-group">
            <label for="phone_no">Phone Number</label>
            <input type="text" name="phone_no" class="form-control rounded" id="phone_no" >
            @error('phone_no') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        </fieldset>

        
           <!-- <a href="{{ route('branch.index') }}" class="btn btn-secondary">Back to Branch List</a> -->
           <button type="submit" class="btn btn-success mt-3">Create </button> 
           <a href="{{ route('branch.index') }}" class="btn btn-secondary mt-3 ml-2">Cancel</a>
        

    </form>
</div>

@endsection