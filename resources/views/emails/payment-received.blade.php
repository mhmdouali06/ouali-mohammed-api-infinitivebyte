<!DOCTYPE html>
<html>
<head>
    <title>Payment Received</title>
</head>
<body>
    <h1>Payment Received</h1>
    <p>Dear Customer,</p>
    <p>We have received your payment of <strong>{{ $payment->amount }}</strong> on <strong>{{ $payment->payment_date }}</strong>.</p>
    <p>Thank you for your prompt payment.</p>
</body>
</html>
