<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Monthly Student Attendance Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Georgia', serif;
            padding: 20px;
        }
        #letterhead {
            font-family: 'Sans-serif', serif;
        }
        #letterhead h2 {
            color: #b30000;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        #letterhead hr {
            border: 1px solid #b30000;
            margin-top: 10px;
            margin-bottom: 30px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.15;
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }
        .no-print {
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Watermark -->
    <div class="watermark">
        <img src="{{ asset('img/logo.jpg') }}" alt="Watermark Logo" style="width: 250px;" />
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
                    <strong><p class="mb-0">Reg No: S.L.K.F/AFF/L/408</p></strong>
                    <strong><p class="mb-0">Email: sjskikarate@gmail.com | Phone: +94 778 506 651</p></strong>
                </div>
            </div>
        </div>
        <hr />
    </div>

    <!-- Print Button -->
    <div class="no-print d-flex justify-content-end mb-3">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print</button>
    </div>

    <!-- Title -->
    <h4 class="text-center my-4">
        Monthly Student Attendance Summary for {{ $formattedMonth }}
      
    </h4>

    <!-- Attendance Table -->
    @if($summary->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Student</th>
                        <th>Total Sessions</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                        <th>Attendance %</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($summary as $record)
                        <tr class="{{ $record['percentage'] < 75 ? 'table-danger' : '' }}">
                            <td>{{ $record['student'] }}</td>
                            <td>{{ $record['total'] }}</td>
                            <td>{{ $record['present'] }}</td>
                            <td>{{ $record['absent'] }}</td>
                            <td>{{ $record['late'] }}</td>
                            <td>{{ $record['percentage'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-muted">No attendance data found for selected filters.</p>
    @endif

</body>
</html>
