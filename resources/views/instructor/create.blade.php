@extends('layouts.admin.master')

@section('content')
       
<div class="col-md-12">

    <h2>Instructor Registration Form</h2>     
    <br>

    <form action="{{ route('instructor.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <fieldset class="border p-4 mb-4">
        <legend class="w-auto px-2"></legend>

        
        <!--first name feild-->
        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" name="name" class="form-control rounded" id="name" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--last name feild-->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control rounded" id="last_name" required>
            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--nic feild-->
        <div class="form-group">
            <label for="nic">NIC Number</label>
            <input type="text" name="nic" class="form-control rounded" id="nic" required>
            @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--admin dob feild-->
        <div class="form-group">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" class="form-control rounded" id="dob" required>
            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control rounded" required>
                <option value="">Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="Other">Other</option>
            </select>
            @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--email feild-->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control rounded" id="email" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--admin phone number feild-->
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" class="form-control rounded" id="phone" required>
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!--admin address feild-->
        <div class="form-group">
            <label for="phone">Address</label>
            <input type="text" name="address" class="form-control rounded" id="address" required>
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Branch Field -->
        <div class="form-group">
            <label for="branch_id">Branch</label>
            <select name="branch_id" id="branch_id" class="form-control rounded" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}"> {{ $branch->branch_name }} </option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Volunteer Field  -->
        <div class="form-group">
            <label for="is_volunteer">Instructor Type</label>
            <select name="is_volunteer" class="form-control rounded" id="is_volunteer" required>
                <option value="">Select Instructor Type</option>
                <option value="1">Volunteer</option>
                <option value="0">Paid Instructor</option>
            </select>
            @error('is_volunteer') <span class="text-danger">{{ $message }}</span> @enderror
        </div>


        </fieldset>

        <fieldset class="border p-4 mb-4">
        <legend class="w-auto px-2">Qualification Details</legend>

            <div class="row">
                <!-- Reg.No Field -->
                <div class="form-group col-md-6">
                    <label for="reg_no">Reg.No of Sri Lanka Karate-do Federation</label>
                    <input type="text" name="reg_no" class="form-control rounded" id="reg_no" required>
                    @error('reg_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Karate Style Field -->
                <div class="form-group col-md-6">
                    <label for="style">Karate Style Followed</label>
                    <input type="text" name="style" class="form-control rounded" id="style" required>
                    @error('style') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">

                <!-- Experience in Karate Field -->
                <div class="form-group col-md-6">
                    <label for="exp_in_karate">Experience in Karate(years)</label>
                    <input type="number" name="exp_in_karate" class="form-control rounded" id="exp_in_karate" required>
                    @error('exp_in_karate') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Experience as Instructor Field -->
                <div class="form-group col-md-6">
                    <label for="exp_as_instructor">Experience as Instructor(years)</label>
                    <input type="number" name="exp_as_instructor" class="form-control rounded" id="exp_as_instructor" required>
                    @error('exp_as_instructor') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

        </fieldset>


        <!-- <fieldset class="border p-4 mb-4">
        <div class="row">
            
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control rounded" id="password" required>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            
            <div class="form-group col-md-6">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control rounded" id="password_confirmation" required>
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

        </div>

        </fieldset> -->

        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
</div>

@endsection

