@extends('layouts.admin.master')

@section('title', 'Edit Belt')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2>Edit Belt Details</h2>
            </div>
            <div class="card-body">

                <!-- Form to edit belts details -->
                <form action="{{ route('belt.update', $belt->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <fieldset class="border p-4 mb-4">
                    
                    <div class="form-group">
                        <label for="belt_name">Name</label>
                        <input type="text" name="belt_name" class="form-control" value="{{ old('belt_name', $belt->belt_name) }}" required>
                        @error('belt_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="rank">Rank</label>
                        <input type="text" name="rank" class="form-control" value="{{ old('rank', $belt->rank) }}" required>
                        @error('rank') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="color">Belt Color</label>
                        <input type="text" name="color" class="form-control" value="{{ old('color', $belt->color) }}" required>
                        @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="requirements">Requirements</label>
                        <input type="requirements" name="requirements" class="form-control" value="{{ old('requirements', $belt->requirements) }}" required>
                        @error('requirements') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="max_attempts">Maximum No of Attempts</label>
                        <input type="text" name="max_attempts" class="form-control" value="{{ old('max_attempts', $belt->max_attempts) }}">
                        @error('max_attempts') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    </fieldset>   

        
        
            <div style="display: flex; gap: 10px; align-items: center; margin-top: 15px;">
            <button type="submit" class="btn btn-success mt-3">Update</button>
                <a href="{{ route('belt.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </div>

    </form>
            </div>
        </div>
    </div>
</div>
@endsection
