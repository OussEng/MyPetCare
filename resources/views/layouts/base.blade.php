<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Little Pet</title>
    @vite('resources/css/app.css')
</head>

<header>@include('layouts._navbar')</header>

<body>

@yield('content')

</body>
<footer class="border-t border-black">@include('layouts._footer')</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.querySelector('button[command="--toggle"]');
        const menu = document.getElementById(btn.getAttribute('commandfor'));

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            const [openIcon, closeIcon] = btn.querySelectorAll('svg');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    });
</script>

</html>
