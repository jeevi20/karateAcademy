@extends('layouts.admin.master')

@section('content')
<div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Achievements of {{ $student->user->name }} {{ $student->user->last_name }}</h2>
        <a href="{{ route('student.index') }}" class="btn btn-dark"> Back </a>
    </div>


    <form action="{{ route('achievement.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="student_id" value="{{ request()->route('studentId') }}">

        <fieldset class="border p-4 mb-4">
            <!-- Achievement Type -->
            <div class="form-group col-md-4">
                <label>Achievement Type</label>
                @php
                    $selectedType = old('achievement_type');
                @endphp
                @foreach(['past_belt', 'academy_belt', 'certificate', 'awards', 'medal'] as $type)
                    <div class="form-check">
                        <input type="radio" name="achievement_type" value="{{ $type }}" class="form-check-input" id="{{ $type }}" 
                            {{ old('achievement_type') == $type ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                    </div>
                @endforeach
                @error('achievement_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Hidden input for achievement_name -->
            <input type="hidden" name="achievement_name" id="achievement_name" value="{{ old('achievement_name') }}">

            <!-- Dynamic Fields Based on Selection -->
            <div class="form-group col-md-4 belt-field" style="display: none;">
                <label for="belt_achievement_name">Belt Achieved?</label>
                <select name="belt_name" id="belt_achievement_name" class="form-control rounded">
                    <option value="">Select the Belt Name Achieved</option>
                    @foreach($belts as $belt)
                        <option value="{{ $belt->belt_name }}" {{ old('belt_name') == $belt->belt_name ? 'selected' : '' }}>
                            {{ $belt->belt_name }}
                        </option>
                    @endforeach
                </select>
                @error('belt_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 certificate-field" style="display: none;">
                <label for="certificate_name">Certificate Name</label>
                <input type="text" name="certificate_name" id="certificate_name" class="form-control rounded" value="{{ old('certificate_name') }}">
                @error('certificate_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 award-field" style="display: none;">
                <label for="award_name">Award Name</label>
                <input type="text" name="award_name" id="award_name" class="form-control rounded" value="{{ old('award_name') }}">
                @error('award_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 medal-field" style="display: none;">
                <label for="medal_name">Medal Name</label>
                <input type="text" name="medal_name" id="medal_name" class="form-control rounded" value="{{ old('medal_name') }}">
                @error('medal_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Achievement Date -->
            <div class="form-group col-md-4">
                <label for="achievement_date">Date of Achievement</label>
                <input type="date" name="achievement_date" class="form-control rounded" id="achievement_date" value="{{ old('achievement_date') }}">
                @error('achievement_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Organization Name -->
            <div class="form-group col-md-4">
                <label for="organization_name">Achieved from which Organization / Club?</label>
                <input type="text" name="organization_name" class="form-control rounded" id="organization_name" value="{{ old('organization_name') }}">
                @error('organization_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Remarks -->
            <div class="form-group col-md-4">
                <label for="remarks">Remarks</label>
                <input type="text" name="remarks" class="form-control rounded" id="remarks" value="{{ old('remarks') }}">
                @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        function toggleAchievementFields() {
            const achievementType = $('input[name="achievement_type"]:checked').val();

            $('.belt-field, .certificate-field, .award-field, .medal-field').hide();
            $('#belt_achievement_name, #certificate_name, #award_name, #medal_name').prop('required', false);

            switch (achievementType) {
                case 'past_belt':
                case 'academy_belt':
                    $('.belt-field').show();
                    $('#belt_achievement_name').prop('required', true);
                    $('#achievement_name').val($('#belt_achievement_name').val());
                    break;
                case 'certificate':
                    $('.certificate-field').show();
                    $('#certificate_name').prop('required', true);
                    $('#achievement_name').val($('#certificate_name').val());
                    break;
                case 'awards':
                    $('.award-field').show();
                    $('#award_name').prop('required', true);
                    $('#achievement_name').val($('#award_name').val());
                    break;
                case 'medal':
                    $('.medal-field').show();
                    $('#medal_name').prop('required', true);
                    $('#achievement_name').val($('#medal_name').val());
                    break;
            }
        }

        $('input[name="achievement_type"]').change(toggleAchievementFields);
        $('#belt_achievement_name, #certificate_name, #award_name, #medal_name').on('input change', function () {
            $('#achievement_name').val($(this).val());
        });

        toggleAchievementFields();
    });
</script>
@endsection
