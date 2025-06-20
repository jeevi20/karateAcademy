@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">

    <h2>Edit Instructor Details</h2>
    <br>

    <form action="{{ route('instructor.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2"></legend>
        <!-- First Name -->
        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control rounded" value="{{ old('last_name', $user->last_name) }}" required>
            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- NIC -->
        <div class="form-group">
            <label for="nic">NIC Number</label>
            <input type="text" name="nic" class="form-control rounded" value="{{ old('nic', $user->nic) }}" required>
            @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Date of Birth -->
        <div class="form-group">
            <label for="dob">Date Of Birth</label>
            <input type="date" name="dob" class="form-control rounded" value="{{ old('dob', $user->dob) }}" required>
            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="" disabled>Select Gender</option>
                <option value="M" {{ old('gender', $user->gender) == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ old('gender', $user->gender) == 'F' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control rounded" value="{{ old('email', $user->email) }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Phone -->
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" class="form-control rounded" value="{{ old('phone', $user->phone) }}" required>
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control rounded" value="{{ old('address', $user->address) }}" required>
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Branch -->
        <div class="form-group">
            <label for="branch_id">Branch</label>
            <select name="branch_id" id="branch_id" class="form-control rounded" required>
                <option value="">Select Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                        {{ $branch->branch_name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Volunteer Field  -->
        <div class="form-group">
            <label for="is_volunteer">Instructor Type</label>
            <select name="is_volunteer" class="form-control rounded" id="is_volunteer" required>
                <option value="">Select Instructor Type</option>
                <option value="1" {{ old('is_volunteer', $user->instructor->is_volunteer) == '1' ? 'selected' : '' }}>Volunteer</option>
                <option value="0" {{ old('is_volunteer', $user->instructor->is_volunteer) == '0' ? 'selected' : '' }}>Paid Instructor</option>
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
                <input type="text" name="reg_no" class="form-control rounded" value="{{ old('reg_no', $user->instructor->reg_no ?? '') }}" required>
                @error('reg_no') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

           <!-- Karate Style Field -->
           <div class="form-group col-md-6">
                <label for="style">Karate Style Followed</label>
                <input type="text" name="style" class="form-control rounded" value="{{ old('style', $user->instructor->style ?? '') }}" required>
                @error('style') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <!-- Experience in Karate Field -->
            <div class="form-group col-md-6">
                <label for="exp_in_karate">Experience in Karate (years)</label>
                <input type="number" name="exp_in_karate" class="form-control rounded" value="{{ old('exp_in_karate', $user->instructor->exp_in_karate ?? '') }}" required>
                @error('exp_in_karate') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Experience as Instructor Field -->
            <div class="form-group col-md-6">
                <label for="exp_as_instructor">Experience as Instructor (years)</label>
                <input type="number" name="exp_as_instructor" class="form-control rounded" value="{{ old('exp_as_instructor', $user->instructor->exp_as_instructor ?? '') }}" required>
                @error('exp_as_instructor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </fieldset>


        <div style="display: inline-block;">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('instructor.index') }}" class="btn btn-secondary ml-2">Cancel</a>
        </div>

    </form>
</div>

@endsection
