<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<body>
    <h2> Dear <span>{{ $details['name'] }}</span></h2>
    <p>Welcome to portal</p>
    <a href="http://127.0.0.1:8000/auth/verify/{{ $details['token'] }}/{{ $details['email'] }}">Verify here</a>
</body>
</html>
