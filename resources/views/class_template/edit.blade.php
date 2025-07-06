@extends('layouts.admin.master')

@section('content')

<div class="container">
    <div class="col-md-12">
        <h2>Edit Class Template</h2>
        <br>

        <form action="{{ route('class_template.update', $karateClassTemplate->id) }}" method="POST">

            @csrf
            @method('PUT')

            <fieldset class="border p-4 mb-4">

                <!-- Class Name -->
                <div class="form-group col-md-4">
                    <label for="class_name">Class Name</label>
                    <input type="text" name="class_name" class="form-control rounded" id="class_name" value="{{ old('class_name', $karateClassTemplate->class_name) }}" required>
                    @error('class_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <!-- Start Time -->
                <div class="form-group col-md-4">
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" class="form-control rounded" id="start_time" value="{{ old('start_time', $karateClassTemplate->start_time) }}" required>
                    @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- End Time -->
                <div class="form-group col-md-4">
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" class="form-control rounded" id="end_time" value="{{ old('end_time', $karateClassTemplate->end_time) }}" required>
                    @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Day -->
                <div class="form-group col-md-4">
                    <label for="day">Day</label>
                    <select name="day" class="form-control rounded" id="day" required>
                        <option value="" disabled>Select Day</option>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}" {{ old('day', $karateClassTemplate->day) == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('day') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <br>
                <div style="display: inline-block;">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('class_template.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                </div>

            </fieldset>
        </form>
    </div>
</div>

@endsection
