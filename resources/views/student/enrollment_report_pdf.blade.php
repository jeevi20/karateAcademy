<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Enrollment Report</title>
    
    <style>
        .no-print {
            display: block;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .opacity-25 {
                opacity: 0.07 !important;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid px-4 position-relative">

    <!-- Watermark -->
    <div class="position-absolute top-50 start-50 translate-middle opacity-25" style="z-index: 0;">
        <img src="{{ asset('img/logo.jpg') }}" alt="Watermark Logo" style="width: 190px; max-width: 50%;">
    </div>

    <!-- Print/Download Buttons -->
    <div class="d-flex justify-content-end gap-2 my-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print</button>
        <a href="{{ route('student.enrollment_report_pdf', request()->all()) }}" target="_blank" class="btn btn-success">⬇️ Download PDF</a>
    </div>

    <!-- Letterhead -->
    @include('layouts.admin.letterhead')

    <!-- Title -->
    <h2 class="text-center my-3">Student Enrollment Report</h2>

    <p class="text-end" style="font-size: 14px;">
        Date Printed: {{ \Carbon\Carbon::now()->format('F j, Y, g:i A') }}
    </p>

    <!-- Student Table (same as your report table) -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Reg. No</th>
                    <th>Branch</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->student->student_reg_no }}</td>
                        <td>{{ $student->branch?->branch_name ?? '-' }}</td>
                        <td>{{ $student->student->karateClassTemplate->class_name }}</td>
                        <td>{{ ucfirst($student->gender) }}</td>
                        <td>{{ $student->student->enrollment_date }}</td>
                        <td>{{ ucfirst($student->student->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
