@extends('layouts.base')
@section('content')

    <div class="w-2/3 mx-auto my-auto mb-28 mt-10">

        <div>
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white inline-flex items-center">
            Vaccination list
        </h1>
            <div class="relative inline-block group ml-4 self-center"> <!-- Added ml-4 for spacing -->
                <!-- Trigger Button (SVG Icon) -->
                <button class="text-gray-500 hover:text-gray-700">
                    <svg width="30px" height="30px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#000000" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm0 192a58.432 58.432 0 0 0-58.24 63.744l23.36 256.384a35.072 35.072 0 0 0 69.76 0l23.296-256.384A58.432 58.432 0 0 0 512 256zm0 512a51.2 51.2 0 1 0 0-102.4 51.2 51.2 0 0 0 0 102.4z"/>
                    </svg>
                </button>

                <!-- Popover Content -->
                <div class="absolute hidden group-hover:block bg-white text-gray-700 text-sm rounded-lg shadow-lg p-4 mt-2 w-64 left-1/2 transform -translate-x-1/2">
                    <p>⚠️ Veuillez ne pas ajouter ni retirer une vaccination sauf si vous êtes certain(e) qu’elle a bien été faite.</p>
                </div>
            </div>
        </div>






    @forelse($vaccinations as $vaccination)
            <div id="alert-additional-content-1"
                 class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                 role="alert">
                <div class="flex items-center">
                    <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M441 7l32 32 32 32c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-15-15L417.9 128l55 55c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-72-72L295 73c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l55 55L422.1 56 407 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0zM210.3 155.7l61.1-61.1c.3 .3 .6 .7 1 1l16 16 56 56 56 56 16 16c.3 .3 .6 .6 1 1l-191 191c-10.5 10.5-24.7 16.4-39.6 16.4l-88.8 0L41 505c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l57-57 0-88.8c0-14.9 5.9-29.1 16.4-39.6l43.3-43.3 57 57c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6l-57-57 41.4-41.4 57 57c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6l-57-57z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">{{$vaccination->nom_vaccine}}</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    {{$vaccination->info}}
                </div>
                <div class="flex">
                    <form action="{{ route('vaccination.remove', [$animal->id , $vaccination->id]) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded shadow-md transition duration-200">
                            Retirer
                        </button>
                    </form>
                </div>
            </div>

                    @empty
                        <div
                            class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <span class="font-medium">Attention</span> cet animal n'est pas vacciné
                        </div>

                    @endforelse

                </div>


                <div class="w-1/2 mx-auto my-auto">
                    <h2 class="text-4xl font-extrabold dark:text-white mb-10">Ajouter des vaccins :</h2>

                    <div>

                        <form action="{{ route('vaccinations.add' , $animal->id) }}" method="POST">
                            @csrf
                            <label class="block mb-5 text-sm font-medium text-gray-900 dark:text-white">Select
                                Vaccinations:</label>


                            @if($animal->espece->libelle == 'chien')
                                @foreach($chien_vaccination as $chienvac)

                                    <div
                                        class="flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700">
                                        <input id="bordered-checkbox-1" type="checkbox" value="{{ $chienvac->id }}"
                                               name="vaccinations[]"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="bordered-checkbox-1"
                                               class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $chienvac->nom_vaccine }}</label>
                                    </div>

                                @endforeach
                            @endif
                            @if($animal->espece->libelle == 'chat')

                                @foreach($chat_vaccinations as $chatvac)

                                    <div
                                        class="flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700">
                                        <input id="bordered-checkbox-1" type="checkbox" value="{{ $chatvac->id }}"
                                               name="vaccinations[]"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="bordered-checkbox-1"
                                               class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $chatvac->nom_vaccine }}</label>
                                    </div>
                                @endforeach
                            @endif


                            <button type="submit"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                Ajouter
                            </button>

                        </form>


                    </div>


                </div>

@endsection
