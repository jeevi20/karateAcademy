@extends('layouts.admin.master')

@section('title', 'Edit Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Edit BranchStaff Details</h2>
            </div>
            <div class="card-body">

                <!-- Form to edit branchstaff details -->
                <form action="{{ route('branchstaff.update', $branchStaff->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Role Field -->
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" class="form-control rounded" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $branchStaff->role_id ? 'selected' : '' }}> {{ $role->role_name }} </option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $branchStaff->name) }}" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $branchStaff->last_name) }}" required>
                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $branchStaff->email) }}" required>
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $branchStaff->phone) }}" required>
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $branchStaff->address) }}">
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $branchStaff->dob) }}">
                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="M" {{ old('gender', $branchStaff->gender) == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender', $branchStaff->gender) == 'F' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $branchStaff->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label for="nic">NIC</label>
                        <input type="text" name="nic" class="form-control" value="{{ old('nic', $branchStaff->nic) }}">
                        @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Branch Field -->
                    <div class="form-group">
                        <label for="branch_id">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-control rounded" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $branchStaff->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>


            <fieldset class="border p-4 mb-4">
            <div class="row">
            <!-- password field -->
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control rounded" id="password" >
                <small>Leave empty if you don't want to change the password.</small>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- confirm password field -->
            <div class="form-group col-md-6">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control rounded" id="password_confirmation" >
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            </div>

        </fieldset>
        
            <div style="display: flex; gap: 10px; align-items: center; margin-top: 15px;">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('branchstaff.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

    </form>
            </div>
        </div>
    </div>
</div>
@endsection
