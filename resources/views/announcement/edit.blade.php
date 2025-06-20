@extends('layouts.admin.master')

@section('content')
<div class="col-md-12">
    <h2>Edit Announcement</h2>
    <br>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('announcement.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">

            <!-- Title Field -->
            <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control rounded" id="title" value="{{ $announcement->title }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Body Field -->
            <div class="form-group col-md-8">
                <label for="body">Body</label>
                <textarea name="body" class="form-control rounded" id="body" rows="4" required>{{ $announcement->body }}</textarea>
                @error('body') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Date Field -->
            <div class="form-group col-md-4">
                <label for="announcement_date">Date</label>
                <input type="date" name="announcement_date" class="form-control rounded" 
                    id="announcement_date" value="{{ old('announcement_date', \Carbon\Carbon::parse($announcement->announcement_date)->format('Y-m-d')) }}" required>
                @error('announcement_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>



            <!-- Audience Field -->
            <div class="form-group col-md-4">
                <label for="audience">Audience</label>
                <select name="audience" id="audience" class="form-control rounded">
                    <option value="all" {{ $announcement->audience == 'all' ? 'selected' : '' }}>All</option>
                    <option value="branchstaff" {{ $announcement->audience == 'branchstaff' ? 'selected' : '' }}>Branch Staff</option>
                    <option value="instructors" {{ $announcement->audience == 'instructors' ? 'selected' : '' }}>Instructors</option>
                    <option value="students" {{ $announcement->audience == 'students' ? 'selected' : '' }}>Students</option>
                </select>
                @error('audience') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Image Field -->
            <div class="form-group col-md-6">
                <label for="image">Upload Image</label>
                <input type="file" name="image" class="form-control rounded" id="image">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                @if($announcement->image)
                    <br>
                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="Current Image" width="100">
                    <p>Current Image</p>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mt-3">Update</button>
            <a href="{{ route('announcement.index') }}" class="btn btn-secondary mt-3">Cancel</a>

        </fieldset>
    </form>
</div>
@endsection
