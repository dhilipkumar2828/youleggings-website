<!DOCTYPE html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Authendication Email</title>

</head>

<body>

    <h1>Hi {{ $bookMail['name'] }}</h1>

    <p>Name : {{ $bookMail['name'] }}</p>

    <p>Message : {{ $bookMail['message'] }}</p>

    <p>Email : {{ $bookMail['email'] }}</p>

    <p>{{ $bookMail['Body'] }}</p>

</body>

</html>
