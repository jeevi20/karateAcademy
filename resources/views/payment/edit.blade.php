@extends('layouts.admin.master')
@section('title', 'Edit Payment Details')
@section('content')

<div class="col-md-12">
    <h2>Edit Payment Details</h2>
    <br>

    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset class="border p-4 mb-4">

            <!-- Student Name Field -->
            <div class="form-group col-md-4">
                <label for="student_id">Student Name</label>
                <select name="student_id" id="student_id" class="form-control rounded">
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Payment Category Field -->
            <div class="form-group col-md-4">
                <label for="payment_category">Payment Category</label>
                <select name="payment_category" id="payment_category" class="form-control rounded">
                    <option value="">Select Payment Category</option>
                    <option value="Registration" {{ old('payment_category', $payment->payment_category) == 'Registration' ? 'selected' : '' }}>Registration</option>
                    <option value="Grading Exam" {{ old('payment_category', $payment->payment_category) == 'Grading Exam' ? 'selected' : '' }}>Grading Exam</option>
                    <option value="Monthly Class" {{ old('payment_category', $payment->payment_category) == 'Monthly Class' ? 'selected' : '' }}>Monthly Class</option>
                    <option value="Certification" {{ old('payment_category', $payment->payment_category) == 'Certification' ? 'selected' : '' }}>Certification</option>
                    <option value="Other" {{ old('payment_category', $payment->payment_category) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('payment_category') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Grading Exam Selection Field -->
            <div class="form-group col-md-4" id="grading_exam_field" style="display: none;">
                <label for="event_id">Grading Exam</label>
                <select name="event_id" id="event_id" class="form-control rounded">
                    <option value="">Select Grading Exam</option>
                    @foreach($gradingExams as $exam)
                        <option value="{{ $exam->id }}" 
                            {{ old('event_id', $payment->event_id) == $exam->id ? 'selected' : '' }}>
                            {{ $exam->title }} ({{ $exam->event_date }})
                        </option>
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
                        <option value="{{ $belt->id }}" 
                            {{ old('belt_want_to_receive', $payment->belt_want_to_receive) == $belt->id ? 'selected' : '' }}>
                            {{ $belt->belt_name }}
                        </option>
                    @endforeach
                </select>
                @error('belt_want_to_receive') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Amount Field -->
            <div class="form-group col-md-4">
                <label for="amount">Amount (Rs.)</label>
                <input type="number" name="amount" class="form-control rounded" id="amount" value="{{ old('amount', $payment->amount) }}" required>
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Date Paid Field -->
            <div class="form-group col-md-4">
                <label for="date_paid">Date Paid</label>
                <input type="date" name="date_paid" class="form-control rounded" id="date_paid" value="{{ old('date_paid', $payment->date_paid) }}" required>
                @error('date_paid') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Notes Field -->
            <div class="form-group col-md-4">
                <label for="notes">Notes</label>
                <textarea name="notes" class="form-control rounded" id="notes" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <br>
            <div style="display: inline-block;">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('payment.index') }}" class="btn btn-secondary ml-2">Cancel</a>
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

        toggleFields();

        $paymentCategory.on('change', toggleFields);
    });
</script>
@endsection
