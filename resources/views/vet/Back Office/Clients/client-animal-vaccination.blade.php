@extends('layouts.backoffice')

@section('content')

    <div class="ml-72 pt-10 flex gap-5">

        <a href="{{route('veterinaire.client', $animal->user->id)}}"
           class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
        </a>
        <div class="mb-28 border w-2/3 mr-5 p-5 shadow-xl">
            @forelse($animal->vaccinations as $vaccination)
                <div id="alert-{{ $vaccination->id }}"
                     class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                     role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M441 7l32 32 32 32c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-15-15L417.9 128l55 55c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-72-72L295 73c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l55 55L422.1 56 407 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0zM210.3 155.7l61.1-61.1c.3 .3 .6 .7 1 1l16 16 56 56 56 56 16 16c.3 .3 .6 .6 1 1l-191 191c-10.5 10.5-24.7 16.4-39.6 16.4l-88.8 0L41 505c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l57-57 0-88.8c0-14.9 5.9-29.1 16.4-39.6l43.3-43.3 57 57c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6l-57-57 41.4-41.4 57 57c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6l-57-57z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">{{ $vaccination->nom_vaccine }}</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        {{ $vaccination->info }}
                    </div>
                    <form action="{{ route('vaccination.remove', [$animal->id , $vaccination->id]) }}"
                          method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200">
                            Retirer
                        </button>
                    </form>
                </div>
            @empty
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                     role="alert">
                    <span class="font-medium">Attention</span> cet animal n'est pas vacciné
                </div>
            @endforelse
        </div>


        <div class="mb-28 border p-5">
            <h2 class="text-2xl font-extrabold dark:text-white mb-10">Ajouter des vaccins :</h2>

            <form action="{{ route('vaccinations.add' , $animal->id) }}" method="POST">
                @csrf

                @foreach($vaccinations as $vaccination)
                    <div class="flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700 mb-2">
                        <input id="vaccination-{{ $vaccination->id }}" type="checkbox" value="{{ $vaccination->id }}"
                               name="vaccinations[]"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="vaccination-{{ $vaccination->id }}"
                               class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $vaccination->nom_vaccine }}</label>
                    </div>
                @endforeach

                <button type="submit"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Ajouter
                </button>
            </form>
        </div>


    </div>

@endsection
