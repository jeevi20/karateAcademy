<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Card</title> 
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: auto; border: 2px solid black; padding: 20px; position: relative; }

        /* Position the barcode in the top-right corner */
        .barcode {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        h2 { text-transform: uppercase; }
        .details { text-align: center; margin-top: 20px; }

        /* Styling for table */
        table {
            width: 100%;
            margin-top: 40px;
            border-spacing: 20px;
            text-align: center;
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
            text-transform: lowercase;
            margin-top: 20px;
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barcode positioned at the top-right corner -->
        <div class="barcode">
        {!! DNS1D::getBarcodeHTML($student->user_id . '-' . $exam->id, 'C39') !!}
        </div>
        <br><br>

        <h2>Grading Examination Admission Card</h2> 

        <br>

        <div class="details">
        <p><strong>Student Name:</strong> {{ $student->user->name ?? 'N/A' }} {{ $student->user->last_name ?? 'N/A' }}</p>
        <p><strong>Exam:</strong> {{ $exam->title ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($exam->event_date)->format('F j, Y') ?? 'N/A' }}</p>

        </div>

        <!-- Table for Signatures -->
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

        <!-- Instructions outside the table -->
        <p class="instructions">Please sign above before the exam. Bring this admission card to the grading exam.</p>
    </div>
</body>
</html>
<br> <br>
<div>
<a href="{{ route('grading_exam.admission_card.download', ['exam' => $exam->id, 'student' => $student->user_id]) }}" class="btn btn-success" style="margin-top: 20px;">
    Download Admission Card
</a>


</div>