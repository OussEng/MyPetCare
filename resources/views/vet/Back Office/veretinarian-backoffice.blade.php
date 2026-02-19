@extends('layouts.backoffice')
@section('content')
    <div class="ml-64">
    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl p-6">
    <span class="block">
        Bienvenue Dr.
        <span class="text-transparent bg-clip-text bg-gradient-to-tr to-cyan-500 from-blue-600">
            {{Auth::user()->nom}}
        </span>
    </span>
    </h1>

    <div class="flex justify-center mt-20 " >
        <div class="max-w-80 w-full mr-5 transition delay-100 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110">
            <div class="pt-3 overflow-hidden bg-gray-100 border border-gray-200 rounded-md shadow">
                <h1 class="text-gray-900 text-xl font-semibold pl-6 pb-3">Rendez Vous Aujourd'hui:</h1>

                <div class="text-gray-900 bg-white pb-3 pt-6 text-sm flex justify-center">
                    <span class="text-5xl text-green-600 font-bold">{{count($rendez_vous)}}</span>
                </div>
            </div>
            <button type="button" class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all w-full h-10 mt-5 rounded-md">Voir</button>
        </div>

        <div class="max-w-80 w-full transition delay-100 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110">
            <div class="pt-3 overflow-hidden bg-gray-100 border border-gray-200 rounded-md shadow">
                <h1 class="text-gray-900 text-xl font-semibold pl-6 pb-3">Rendez Vous En attente:</h1>

                <div class="text-gray-900 bg-white pb-3 pt-6 space-y-1 text-sm flex justify-center">
                   <span class="text-5xl text-yellow-500 font-bold"> 1 (TODO) </span> {{-- <--------state handling has not been set up yet--}}
                </div>
            </div>
            <button type="button" class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all w-full h-10 mt-5 rounded-md">Voir</button>
        </div>
    </div>
    </div>


@endsection
