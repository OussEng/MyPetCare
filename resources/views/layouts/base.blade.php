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
<div class="fixed mt-10 z-50 w-80 left-1/2 -translate-x-1/2">
@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 border-green-800 border-2">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 text-red-800 border-red-800 px-4 py-3 rounded mb-4 border-2">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div class="bg-yellow-100 text-yellow-800 border-yellow-800 px-4 py-3 rounded mb-4 border-2">
        {{ session('warning') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-800 border-red-800 px-4 py-3 rounded mb-4 border-2">
        Vous avez {{ $errors->count() }} erreur(s).
    </div>
@endif
</div>
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
