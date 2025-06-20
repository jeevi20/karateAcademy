<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body { 
        font-family: Arial, sans-serif; 
        margin: 0; 
        padding: 0; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100vh; 
        background-color: #f9f9f9; 
    }
    .container {
        border: 2px solid black; 
        padding: 20px; 
        text-align: center; 
        width: 80%; 
        max-width: 600px; 
        background-color: white;
    }
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        position: relative;
        padding: 0 10px;
    }
    .header img {
        max-height: 50px;
        margin-right: 20px;
    }
    .header .title {
        flex-grow: 1;
        text-align: center;
    }
    .header h2 {
        margin: 0;
        font-size: 18px;
    }
    .header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }
    .content {
        text-align: left;
        margin: 0 auto;
    }
    .content p {
        margin: 10px 0;
    }
    .btn {
        display: inline-block; 
        padding: 10px 15px; 
        background-color: #6c757d; 
        color: white; 
        text-decoration: none; 
        border-radius: 5px; 
        font-size: 14px; 
    }
    .btn:hover {
        background-color: #5a6268;
    }
    hr {
        margin-top: 10px; 
        height: 1px; 
        border: 1px dashed black;
    }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('img/logo.jpg') }}" alt="logo">
            <div class="title">
                <h2>Academy of Japanese Shotokan Karate International - Northern Province</h2>
                <br>
                <h1>Payment Receipt</h1>
            </div>
        </div>

        <hr>

        <div class="content">
            <p><strong>Reference No:</strong> {{ $payment->reference_no }}</p>
            <p><strong>Student Name:</strong> {{ $payment->student->name }}</p>
            <p><strong>Payment Category:</strong> {{ $payment->payment_category }}</p>
            <p><strong>Amount:</strong> Rs.{{ number_format($payment->amount, 2) }}</p>
            <p><strong>Date Paid:</strong> {{ $payment->date_paid }}</p>
            <p><strong>Branch:</strong> {{ $payment->student->branch->branch_name }}</p>
            <p><strong>Recorded By:</strong> {{ $payment->createdBy->name }}</p>
            <p><strong>Notes:</strong> {{ $payment->notes }}</p>

        </div>
    </div>
</body>
</html>
