@extends('layouts.admin.master')

@section('content')
<div class="col-md-12">
    <h2>Create Announcement</h2>
    <br>

    <form action="{{ route('announcement.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset class="border p-4 mb-4">
            <!-- Title Field -->
            <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control rounded" id="title" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Body Field -->
            <div class="form-group col-md-6">
                <label for="body">Body</label>
                <textarea name="body" class="form-control rounded" id="body" rows="4" required></textarea>
                @error('body') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Announcement Date -->
            <div class="form-group col-md-6">
                <label for="announcement_date">Date</label>
                <input type="date" name="announcement_date" class="form-control rounded" id="announcement_date" required>
                @error('announcement_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Audience Selection -->
            <div class="form-group col-md-6">
                <label for="audience">Audience</label>
                <select name="audience" id="audience" class="form-control rounded">
                    <option value="all">All</option>
                    <option value="branchstaff">Branch Staff</option>
                    <option value="instructors">Instructors</option>
                    <option value="students">Students</option>
                </select>
                @error('audience') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Image Upload -->
            <div class="form-group col-md-6">
                <label for="image">Upload Image (Optional)</label>
                <input type="file" name="image" class="form-control-file" id="image">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mt-3">Create</button>
        </fieldset>
    </form>
</div>
@endsection




