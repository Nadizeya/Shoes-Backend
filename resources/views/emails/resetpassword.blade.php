<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    {{-- <p>Hello {{ $details['name'] }},</p> --}}
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <p> Restcode : <h1> {{$mailData['message']}}</h1>

    </p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thank you!</p>
</body>
</html>
