@extends('layouts.admin.master')
@section('content')

<div class="col-md-12">
    <h2>Student Registration Form</h2>
    <br>

    <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2"></legend>

            <div class="row">
                <!-- First name -->
                <div class="form-group col-md-6">
                    <label for="name">First Name</label>
                    <input type="text" name="name" class="form-control rounded" id="name" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Last name -->
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control rounded" id="last_name" required>
                    @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- NIC -->
                <div class="form-group col-md-6">
                    <label for="nic">NIC Number</label>
                    <input type="text" name="nic" class="form-control rounded" id="nic">
                    <small>Leave empty if you don't have NIC</small>
                    @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Date of Birth -->
                <div class="form-group col-md-6">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control rounded" id="dob" required>
                    @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Gender -->
                <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control rounded" required>
                        <option value="">Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control rounded" id="email" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="form-group col-md-6">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" class="form-control rounded" id="phone" required>
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="form-group col-md-6">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control rounded" id="address" required>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2">Past Experience Details</legend>

            <div class="form-group">
                <label>Do you have past karate experience?</label>
                <div>
                    <input type="radio" id="experience_yes" name="past_experience" value="yes" required>
                    <label for="experience_yes">Yes</label>
                    <br>
                    <input type="radio" id="experience_no" name="past_experience" value="no" required>
                    <label for="experience_no">No</label>
                </div>
            </div>

            <div id="experience_details" style="display: none;" class="border p-4 mb-4">
                <div class="row">
                    <!-- Achievement Type -->
                    <div class="form-group col-md-6">
                        <label for="achievement_type">Achievement Type</label>
                        <select name="achievement_type" id="achievement_type" class="form-control rounded">
                            <option value="">Achievement Type</option>
                            <option value="past_belt">Past Belt</option>
                        </select>
                        @error('achievement_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Achievement Name -->
                    <div class="form-group col-md-6">
                        <label for="achievement_name">Belt Achieved?</label>
                        <select name="achievement_name" id="achievement_name" class="form-control rounded">
                            <option value="">Select the Belt Name Achieved</option>
                            @foreach($belts as $belt)
                                <option value="{{ $belt->belt_name }}">{{ $belt->belt_name }}</option>
                            @endforeach
                        </select>
                        @error('achievement_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Achievement Date -->
                    <div class="form-group col-md-6">
                        <label for="achievement_date">Date of Achievement</label>
                        <input type="date" name="achievement_date" class="form-control rounded" id="achievement_date">
                        @error('achievement_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Organization Name -->
                    <div class="form-group col-md-6">
                        <label for="organization_name">Belt from which Organization / Club?</label>
                        <input type="text" name="organization_name" class="form-control rounded" id="organization_name">
                        @error('organization_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="form-group col-md-6">
                        <label for="remarks">Remarks</label>
                        <input type="text" name="remarks" class="form-control rounded" id="remarks">
                        @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2">Enrollment Details</legend>

            <div class="row">
                <!-- Class -->
                <div class="form-group col-md-6">
                    <label for="karate_class_template_id">Which Class Are You Enrolling In?</label>
                    <select name="karate_class_template_id" id="karate_class_template_id" class="form-control rounded" required>
                        <option value="">Select Class</option>
                        @foreach($karateClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                    @error('karate_class_template_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Enrollment Date -->
                <div class="form-group col-md-6">
                    <label for="enrollment_date">Enrollment Date</label>
                    <input type="date" name="enrollment_date" class="form-control rounded" id="enrollment_date" required>
                    @error('enrollment_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Branch -->
                <div class="form-group col-md-6">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control rounded" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control rounded" required>
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Graduated">Graduated</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="border p-4 mb-4">
            <div class="row">
                <!-- Password -->
                <div class="form-group col-md-6" id="passwordField" style="display: none;">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control rounded" id="password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group col-md-6" id="confirmPasswordField" style="display: none;">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded" id="password_confirmation">
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        function toggleExperienceDetails() {
            const experienceValue = $('input[name="past_experience"]:checked').val();
            if (experienceValue === 'yes') {
                $('#experience_details').show();
                $('#achievement_name, #organization_name').prop('required', true).prop('disabled', false);
            } else {
                $('#experience_details').hide();
                $('#achievement_name, #organization_name').prop('required', false).prop('disabled', true);
            }
        }

        $('input[name="past_experience"]').change(function () {
            toggleExperienceDetails();
        });

        toggleExperienceDetails();

        $("#nic").on("input", function () {
            if ($.trim($(this).val()) === "") {
                $("#passwordField, #confirmPasswordField").show();
            } else {
                $("#passwordField, #confirmPasswordField").hide();
            }
        });
    });
</script>
@endsection
