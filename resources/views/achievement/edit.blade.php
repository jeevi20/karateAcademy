@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Achievements of {{ $student->user->name }} {{ $student->user->last_name }}</h2>
        <a href="{{ route('student.index') }}" class="btn btn-dark"> Back </a>
    </div>

<br>

<form action="{{ route('achievement.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="user_id" value="{{ $achievement->user_id }}">

    <fieldset class="border p-4 mb-4">

        <!-- Achievement Type -->
        <div class="form-group col-md-4">
            <label>Achievement Type</label>
            @php $types = ['past_belt', 'academy_belt', 'certificate', 'awards', 'medal']; @endphp
            @foreach($types as $type)
                <div class="form-check">
                    <input type="radio" name="achievement_type" value="{{ $type }}" class="form-check-input" id="{{ $type }}"
                        {{ $achievement->achievement_type == $type ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                </div>
            @endforeach
            @error('achievement_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Hidden input for achievement_name -->
        <input type="hidden" name="achievement_name" id="achievement_name" value="{{ $achievement->achievement_name }}">

        <!-- Belt Selection -->
        <div class="form-group col-md-4" id="belt_field" style="display: none;">
            <label for="belt_achievement_name">Belt Achieved?</label>
            <select name="belt_name" id="belt_achievement_name" class="form-control rounded">
                <option value="">Select the Belt Name Achieved</option>
                @foreach($belts as $belt)
                    <option value="{{ $belt->belt_name }}" 
                        {{ $achievement->achievement_name == $belt->belt_name ? 'selected' : '' }}>{{ $belt->belt_name }}</option>
                @endforeach
            </select>
            @error('belt_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Certificate Field -->
        <div class="form-group col-md-4" id="certificate_field" style="display: none;">
            <label for="certificate_name">Certificate Name</label>
            <input type="text" name="certificate_name" id="certificate_name" class="form-control rounded"
                value="{{ $achievement->achievement_type == 'certificate' ? $achievement->achievement_name : '' }}">
            @error('certificate_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Award Field -->
        <div class="form-group col-md-4" id="award_field" style="display: none;">
            <label for="award_name">Award Name</label>
            <input type="text" name="award_name" id="award_name" class="form-control rounded"
                value="{{ $achievement->achievement_type == 'awards' ? $achievement->achievement_name : '' }}">
            @error('award_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Medal Field -->
        <div class="form-group col-md-4" id="medal_field" style="display: none;">
            <label for="medal_name">Medal Name</label>
            <input type="text" name="medal_name" id="medal_name" class="form-control rounded"
                value="{{ $achievement->achievement_type == 'medal' ? $achievement->achievement_name : '' }}">
            @error('medal_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Achievement Date -->
        <div class="form-group col-md-4">
            <label for="achievement_date">Date of Achievement</label>
            <input type="date" name="achievement_date" class="form-control rounded" id="achievement_date"
                value="{{ $achievement->achievement_date }}">
            @error('achievement_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Organization Name -->
        <div class="form-group col-md-4">
            <label for="organization_name">Achieved from which Organization / Club?</label>
            <input type="text" name="organization_name" class="form-control rounded" id="organization_name"
                value="{{ $achievement->organization_name }}">
            @error('organization_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Remarks -->
        <div class="form-group col-md-4">
            <label for="remarks">Remarks</label>
            <input type="text" name="remarks" class="form-control rounded" id="remarks"
                value="{{ $achievement->remarks }}">
            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </fieldset>
</form>

</div>

@endsection
