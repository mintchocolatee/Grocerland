<!DOCTYPE html>
<html>

<head>
    <title>Verify Email</title>
</head>

<body>
    <h1>Verify Your Email Address</h1>
    <p>Click the link below to verify your email address:</p>
    <a href="{{ route('user.verifyEmail', $token) }}">Verify Email</a>
</body>

</html>
