<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admission Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border: 2px solid black;
            padding: 20px;
            position: relative;
            background-color: white;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            z-index: 1;
        }

        .barcode {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.05;
            width: 300px;
            z-index: 0;
        }

        h2 {
            text-transform: uppercase;
            margin-top: 100px;
            z-index: 1;
        }

        .academy-name {
            font-weight: bold;
            margin-top: -10px;
            z-index: 1;
        }

        .details {
            text-align: center;
            margin-top: 20px;
            z-index: 1;
        }

        table {
            width: 100%;
            margin-top: 40px;
            border-spacing: 20px;
            text-align: center;
            z-index: 1;
        }

        td {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            margin: 0 auto;
            padding-top: 5px;
        }

        .instructions {
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            z-index: 1;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Watermark Image -->
        <img src="{{ public_path('img/logo.jpg') }}" alt="Watermark" class="watermark">

        <!-- Logo top-left -->
        <div class="logo">
            <img src="{{ public_path('img/logo.jpg') }}" alt="Logo" style="width: 100%;">
        </div>

        <!-- Barcode top-right -->
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($student->student_id . '-' . $exam->id, 'C39') !!}
        </div>

        <br><br>
        <h2>Grading Examination Admission Card</h2>
        <p class="academy-name">Academy of Japanese Shotokan Karate International - Northern Province</p>

        <div class="details">
            <p><strong>Student Name:</strong> {{ $student->user->name ?? 'N/A' }} {{ $student->user->last_name ?? '' }}</p>
            <p><strong>Exam:</strong> {{ $exam->title ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($exam->event_date)->format('F j, Y') ?? 'N/A' }}</p>
        </div>

        <table>
            <tr>
                <td><strong>Student Signature</strong></td>
                <td><strong>Supervisor Signature</strong></td>
            </tr>
            <tr>
                <td><div class="signature-line"></div></td>
                <td><div class="signature-line"></div></td>
            </tr>
        </table>

        <p class="instructions">
            Please sign above before the exam. Bring this admission card to the grading exam.
        </p>
    </div>

    <!-- Footer with Academy and Printed Date -->
    <div class="footer">
        <p><strong>Academy of Japanese Shotokan Karate International - Northern Province</strong></p>
        <p>Downloaded on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}</p>
    </div>

</body>
</html>
