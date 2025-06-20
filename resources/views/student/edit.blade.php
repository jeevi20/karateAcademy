@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">

    <h2>Edit Student Details</h2>
    <br>

    <form action="{{ route('student.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2">Personal Details</legend>
            
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
                <input type="text" name="nic" class="form-control rounded" value="{{ old('nic', $user->nic) }}">
                <small>Leave empty if you don't have NIC</small>
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

        </fieldset>

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2">Enrollment Details</legend>

            <div class="row">
                <!-- Class Field -->
                <div class="form-group col-md-6">
                    <label for="karate_class_template_id">Which Class Are You Enrolling In?</label>
                    <select name="karate_class_template_id" id="karate_class_template_id" class="form-control rounded" required>
                        @foreach($karateClasses as $class)
                            <option value="{{ $class->id }}" 
                                {{ old('karate_class_template_id', $student->student->karate_class_template_id ?? '') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('karate_class_template_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <!-- Enrollment Branch -->
                <div class="form-group col-md-6">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control rounded" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Enrollment Date -->
                <div class="form-group col-md-6">
                    <label for="enrollment_date">Enrollment Date</label>
                    <input type="date" name="enrollment_date" class="form-control rounded" value="{{ old('enrollment_date', optional($user->student)->enrollment_date ? \Carbon\Carbon::parse($user->student->enrollment_date)->format('Y-m-d') : '') }}" required>
                    @error('enrollment_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <!-- Status -->
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control rounded" required>
                        <option value="" disabled>Select Status</option>
                        <option value="Active" {{ old('status', optional($user->student)->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', optional($user->student)->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Graduated" {{ old('status', optional($user->student)->status) == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="Suspended" {{ old('status', optional($user->student)->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

        </fieldset>

        

        <div style="display: inline-block;">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('student.index') }}" class="btn btn-secondary ml-2">Cancel</a>
        </div>

    </form>
</div>

@endsection
