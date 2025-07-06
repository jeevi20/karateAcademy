<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Branch Report - {{ $branch->branch_name }}</title>
    <style>
        @page {
            margin: 140px 40px 60px 40px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        header img {
            width: 100%;
            height: auto;
        }

        h1, h2, h3 {
            margin-bottom: 0;
        }

        h1 { font-size: 24px; margin-bottom: 10px; }
        h2 { font-size: 18px; margin-top: 20px; }
        h3 { font-size: 14px; margin-top: 15px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #666;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .section {
            margin-bottom: 25px;
        }

        .small-text {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    <header>
        
    </header>

    <p><strong>Branch Name:</strong> {{ $branch->branch_name }}</p>
    <p><strong>Address:</strong> {{ $branch->branch_address }}</p>
    <p><strong>Email:</strong> {{ $branch->email }}</p>
    <p><strong>Phone:</strong> {{ $branch->phone_no }}</p>

    {{-- 1. Staff Overview --}}
    <div class="section">
        <h2>1. Staff Overview</h2>
        <p>Total Staff: {{ $staff->count() }}</p>
        @if ($staff->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>NIC</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->nic }}</td>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 2. Student Overview --}}
    <div class="section">
        <h2>2. Student Overview</h2>
        <p>Total Students: {{ $students->count() }}</p>
        @if ($students->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $stu)
                    <tr>
                        <td>{{ $stu->name }}</td>
                        <td>{{ $stu->gender }}</td>
                        <td>{{ $stu->email }}</td>
                        <td>{{ $stu->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 3. Classes --}}
    <div class="section">
        <h2>3. Classes</h2>
        <p>Total Classes: {{ $classes->count() }}</p>
        @if ($classes->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Instructor</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr>
                        <td>{{ $class->title }}</td>
                        <td>{{ $class->instructor->name ?? 'N/A' }}</td>
                        <td>{{ $class->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 4. Events --}}
    <div class="section">
        <h2>4. Events</h2>
        <p>Total Events: {{ $events->count() }}</p>
        @if ($events->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Participants</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_type }}</td>
                        <td>{{ $event->event_date }}</td>
                        <td>{{ $studentsInEvents->where('event_id', $event->id)->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 5. Grading Examinations --}}
    <div class="section">
        <h2>5. Grading Examinations</h2>
        <p>Total Exams: {{ $gradingExams->count() }}</p>
        @if ($gradingExams->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Participants</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gradingExams as $exam)
                    <tr>
                        <td>{{ $exam->title }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $studentsInGradingExams->where('grading_exam_id', $exam->id)->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 6. Achievements --}}
    <div class="section">
        <h2>6. Achievements</h2>
        <p>Total Achievements: {{ $achievements->count() }}</p>
        @if ($achievements->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements as $ach)
                    <tr>
                        <td>{{ $ach->student->user->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $ach->achievement_type)) }}</td>
                        <td>{{ $ach->achievement_name }}</td>
                        <td>{{ $ach->achievement_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- 7. Payments --}}
    <div class="section">
        <h2>7. Payments and Finance</h2>
        <p>Total Payments: {{ $payments->count() }}</p>
        @if ($payments->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Amount</th>
                    <th>For</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $pay)
                    <tr>
                        <td>{{ $pay->student->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($pay->amount, 2) }}</td>
                        <td>{{ ucfirst($pay->payment_type) }}</td>
                        <td>{{ $pay->payment_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</body>
</html>
