@extends('layouts.admin.master')
@section('content')

<div class="col-md-12">
    <h2>Create Payment Details</h2>
    <br>

    <form action="{{ route('payment.store') }}" method="POST">
        @csrf

        <fieldset class="border p-4 mb-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <!-- Student Name Field -->
            <div class="form-group col-md-4">
                <label for="student_id">Student Name</label>
                <select name="student_id" id="student_id" class="form-control rounded">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
                @error('student_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Payment Category Field -->
            <div class="form-group col-md-4">
                <label for="payment_category">Payment Category</label>
                <select name="payment_category" id="payment_category" class="form-control rounded">
                    <option value="">Select Payment Category</option>
                    <option value="Registration">Registration</option>
                    <option value="Grading Exam">Grading Exam</option>
                    <option value="Monthly Class">Monthly Class</option>
                    <option value="Certification">Certification</option>
                    <option value="Other">Other</option>
                </select>
                @error('payment_category') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Grading Exam Selection Field -->
            <div class="form-group col-md-4" id="grading_exam_field" style="display: none;">
                <label for="event_id">Grading Exam</label>
                <select name="event_id" id="event_id" class="form-control rounded">
                    <option value="">Select Grading Exam</option>
                    @foreach($gradingExams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->title }} ({{ $exam->event_date }})</option>
                    @endforeach
                </select>
                @error('event_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Belt Selection Field -->
            <div class="form-group col-md-4" id="belt_field" style="display: none;">
                <label for="belt_want_to_receive">Which Belt Want to Receive?</label>
                <select name="belt_want_to_receive" id="belt_want_to_receive" class="form-control rounded">
                    <option value="">Select Belt</option>
                    @foreach($belts as $belt)
                        <option value="{{ $belt->id }}">{{ $belt->belt_name }}</option>
                    @endforeach
                </select>
                @error('belt_want_to_receive') <span class="text-danger">{{ $message }}</span> @enderror
            </div>



            <!-- Amount Field -->
            <div class="form-group col-md-4">
                <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control rounded" id="amount" value="{{ old('amount') }}" required>
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Date Paid Field -->
            <div class="form-group col-md-4">
                <label for="date_paid">Paid Date</label>
                <input type="date" name="date_paid" class="form-control rounded" id="date_paid" value="{{ old('date_paid') }}" required>
                @error('date_paid') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Notes Field -->
            <div class="form-group col-md-4">
                <label for="notes">Notes</label>
                <textarea name="notes" class="form-control rounded" id="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group d-flex align-items-center gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Save Payment</button>
                <a href="{{ route('payment.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

            
        </fieldset>

        
    </form>

</div>

@endsection

@section('js')

<script>
    $(document).ready(function () {
        const $paymentCategory = $('#payment_category');
        const $gradingExamField = $('#grading_exam_field');
        const $beltField = $('#belt_field');

        function toggleFields() {
            if ($paymentCategory.val() === 'Grading Exam') {
                $gradingExamField.show();
                $beltField.show();
            } else {
                $gradingExamField.hide();
                $beltField.hide();
            }
        }

        // Initial check
        toggleFields();

        // On change event
        $paymentCategory.on('change', toggleFields);
    });
</script>

@endsection
