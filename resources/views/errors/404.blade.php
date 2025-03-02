<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$error->getStatusCode()}} {{$error->getMessage()}}</title>
</head>
<body>
    <body style="margin: 0; padding: 0; height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #f8f9fa; text-align: center; font-family: Arial, sans-serif;">
        <h1 style="font-size: 6rem; color: #dc3545; font-weight: bold;">{{ $error->getStatusCode() }}</h1>
        <h2 style="color: #343a40; font-size: 2rem;">Oops! {{ $error->getMessage() }}</h2>
        <p style="color: #6c757d;">The page you are looking for does not exist or has been moved.</p>
    </body>
</body>
</html>

