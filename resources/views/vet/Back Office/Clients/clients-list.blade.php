@extends('layouts.backoffice')
@section('content')

    <div class="ml-72">

        <h1 class="mt-10 mb-10 text-4xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Nos <span
                class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600 ">Clients</span>
        </h1>

        <div class="flex justify-center mt-10 ">
            <form class="relative w-full max-w-md">
                <input
                    type="text"
                    name="search"
                    placeholder="Recherche..."
                    autocomplete="off"
                    class="w-full rounded-full border border-gray-300 py-2 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        @forelse($clients as $client)
            <div class="border rounded-xl w-10/12 p-5 shadow-md mt-5">
                <ul role="list" class="divide-y divide-gray-100  h-full ml-5">
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <img src="{{asset('imgs/user-pfp.png')}}" alt=""
                                 class="size-12 flex-none rounded-full bg-gray-50"/>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm/6 font-semibold text-gray-900">{{$client->nom}} {{$client->prenom}}</p>
                                <p class="mt-1 truncate text-xs/5 text-gray-500">{{$client->email}}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <a href="{{route('veterinaire.client', $client->id)}}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Consulter</a>
                        </div>
                    </li>
                </ul>
            </div>
        @empty

            <div class="relative flex items-center justify-center p-10">

                <a href="{{route('veterinaire.clients')}}"
                   class="absolute left-10 flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </a>
                <div
                    class="flex items-center w-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v2m0 4h.01M12 3C7.031 3 3 7.031 3 12s4.031 9 9 9 9-4.031 9-9-4.031-9-9-9z"/>
                    </svg>
                    <span class="font-medium">Aucun utilisateur trouvé.</span>
                </div>

            </div>

        @endforelse

    </div>

    <div class="mt-10 ml-24">
        {{ $clients->withQueryString()->links('pagination.custom') }}
    </div>

@endsection
