<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>My little Pet</title>
</head>

<header>@include('layouts._navbar')</header>

<body>

@yield('content')

</body>
<footer class="border-t border-black">@include('layouts._footer')</footer>

</html>
