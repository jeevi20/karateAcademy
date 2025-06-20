@extends('layouts.admin.master')

@section('title', 'Edit Branch')

@section('content')
<div class="col-md-12">
    <h1>Edit Branch</h1>
    <br>

    <form method="POST" action="{{ route('branch.update', $branch->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2">Branch Information</legend>

            <!-- Branch Name Field -->
            <div class="form-group">
                <label for="branch_name">Branch Name</label>
                <input type="text" name="branch_name" class="form-control rounded" id="branch_name" value="{{ old('branch_name', $branch->branch_name) }}" >
                @error('branch_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Branch Address Field -->
            <div class="form-group">
                <label for="branch_address">Branch Address</label>
                <input type="text" name="branch_address" class="form-control rounded" id="branch_address" value="{{ old('branch_address', $branch->branch_address) }}" >
                @error('branch_address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control rounded" id="email" value="{{ old('email', $branch->email) }}" >
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Phone Number Field -->
            <div class="form-group">
                <label for="phone_no">Phone Number</label>
                <input type="text" name="phone_no" class="form-control rounded" id="phone_no" value="{{ old('phone_no', $branch->phone_no) }}">
                @error('phone_no') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </fieldset>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('branch.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
