<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Georgia', serif;
            position: relative;
            min-height: 100vh;
            padding: 20px;
        }
        /* Watermark styles */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.25;
            z-index: 0;
            pointer-events: none;
            user-select: none;
        }

        .watermark img {
            width: 1000px; 
            max-width: 200%;
        }
        /* Letterhead print styles */
        #letterhead {
            font-family: 'San-serif', serif;
        }
        #letterhead h2 {
            color: #b30000;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            font-width: 200px;
        }
        #letterhead hr {
            border: 1px solid #b30000;
            margin-top: 10px;
        }
        /* Hide the print button when printing */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
@php
    $formattedMonth = $month ? \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') : 'All Time';
@endphp
<body>
    <!-- Watermark -->
    <div class="watermark">
        <img src="{{ asset('img/logo.jpg') }}" alt="Watermark Logo" salt="Watermark Logo" style="width: 250px;"/>
    </div>

    <!-- Letterhead -->
    <div id="letterhead" class="d-print-block mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <div style="flex: 0 0 90px;">
            <img src="{{ asset('img/logo.jpg') }}" alt="Academy Logo" style="height: 90px;" />
        </div>

        <!-- Center Content -->
        <div class="flex-grow-1 px-3">
            <h2 class="text-center">Academy of Japanese Shotokan Karate International</h2>
            <h3 class="text-center mb-3">Northern Province</h3>
            <div class="d-flex justify-content-between" style="font-size: 14px; color: rgb(19, 18, 18);">
                <strong> <p class="mb-0">Reg No: S.L.K.F/AFF/L/408</p> </strong>
                 <strong> <p class="mb-0">Email: sjskikarate@gmail.com | Phone: +94 778 506 651</p> </strong>
            </div>
        </div>
    </div>
    <hr />
</div>

<!-- Print Button -->
    <div class="d-flex justify-content-end mb-3 no-print">
        <button id="printBtn" class="btn btn-primary">🖨️ Print</button>
    </div>

    <!-- Page content here -->
    <div class="content">
        <h4 class="text-center">Student Enrollment Report For {{ $formattedMonth }} </h4>

        <br>
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

    <script>
        document.getElementById('printBtn').addEventListener('click', function () {
            window.print();
        });
    </script>

    <style>
        
    </style>
</body>
</html>
