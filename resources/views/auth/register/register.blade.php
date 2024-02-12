<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="email" placeholder="Email">
        <input type="number" name="phone" placeholder="Phone">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
        <button type="submit">Register</button>
</body>
</html>
