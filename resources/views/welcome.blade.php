@extends('layouts.base')

@section('content')

    <div class="relative">
        <img src="{{ asset('imgs/background.jpg') }}" alt="background" class="w-full h-auto">
        <img src="{{ asset('imgs/background-2.jpg') }}" alt="background" class="w-full h-auto">
        <img src="{{ asset('imgs/background-3.jpg') }}" alt="background" class="w-full h-auto">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-transparent text-outline md:text-5xl lg:text-6xl dark:text-white fixed top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2">Offrez à votre compagnon tout l’amour et les soins qu’il mérite.</h1>
        <a href="{{route('list.vets')}}" class="fixed top-3/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2  text-white hover:text-white border border-white hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-3xl text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
            Soins en un clic        </a>



    </div>






@endsection
