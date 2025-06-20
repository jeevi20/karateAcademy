@extends('layouts.admin.master')

@section('title', 'Edit Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Edit Admin</h2>
            </div>
            <div class="card-body">


                <!-- Form to edit admin details -->
                <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $admin->last_name) }}" required>
                        @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone) }}" required>
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $admin->address) }}">
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $admin->dob) }}">
                        @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="M" {{ old('gender', $admin->gender) == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender', $admin->gender) == 'F' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $admin->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="nic">NIC</label>
                        <input type="text" name="nic" class="form-control" value="{{ old('nic', $admin->nic) }}">
                        @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
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
                    <input type="password" name="password_confirmation" class="form-control rounded" id="password_confirmation">
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>

        </fieldset>
        
            <div style="display: flex; gap: 10px; align-items: center; margin-top: 15px;">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
