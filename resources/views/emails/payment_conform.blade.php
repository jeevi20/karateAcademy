<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmation</title>
</head>
<body>
    <h1>Payment Confirmation</h1>

    <p>Dear student,</p>

    <p>Your payment for the {{ $payment->payment_category }} has been received successfully.</p>
    <p>Your payment: Rs. {{ $payment->amount }}</p>

    <p>
       
    </p>

    <p>Thanks,<br>
    Japanese Shotokan Karate Academy inrernational
    </p>
</body>
</html>




