@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">
    <h2>Branch Staff Registration Form</h2>
    <br>

    <form action="{{ route('branchstaff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset class="border p-4 mb-4">
            <legend class="w-auto px-2"></legend>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">First Name</label>
                    <input type="text" name="name" class="form-control rounded" id="name" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control rounded" id="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nic">NIC Number</label>
                    <input type="text" name="nic" class="form-control rounded" id="nic" value="{{ old('nic') }}" required>
                    @error('nic') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control rounded" id="dob" value="{{ old('dob') }}" required>
                    @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control rounded" required>
                        <option value="">Select Gender</option>
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control rounded" id="email" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" class="form-control rounded" id="phone" value="{{ old('phone') }}" required>
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control rounded" id="address" value="{{ old('address') }}" required>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-control rounded" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-success mt-3">Create</button>
        <a href="{{ route('branchstaff.index') }}" class="btn btn-secondary mt-3 ml-2">Cancel</a>
    </form>
</div>

@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nicInput = document.getElementById('nic');
        const dobInput = document.getElementById('dob');
        const genderInput = document.getElementById('gender');

        nicInput.addEventListener('input', function () {
            const nic = this.value.trim();

            let year, days, gender;

            if (/^\d{9}[vVxX]$/.test(nic)) {
                year = parseInt('19' + nic.substring(0, 2));
                days = parseInt(nic.substring(2, 5));
            } else if (/^\d{12}$/.test(nic)) {
                year = parseInt(nic.substring(0, 4));
                days = parseInt(nic.substring(4, 7));
            } else {
                return;
            }

            if (days > 500) {
                gender = 'F';
                days -= 500;
            } else {
                gender = 'M';
            }

            genderInput.value = gender;

            const birthDate = new Date(year, 0);
            birthDate.setDate(days);
            if (!isNaN(birthDate)) {
                dobInput.value = birthDate.toISOString().split('T')[0];
            }
        });
    });
</script>
@endsection

