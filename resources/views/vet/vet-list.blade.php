@extends('layouts.base')
@section('content')
    <div class="relative w-full min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('imgs/vet-background.png') }}');">
                <div class="flex justify-center">
                    <div class="w-2/3">

                            <h1 class="mt-10 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Nos vétérinaires de confiance</h1>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach($vets as $vet)
                                    @if(auth()->user()->id == $vet->user->id)
                                        {{-- hide the profile of the veterinarian connected --}}
                                    @else
                                    <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                        <div class="flex flex-col items-center pb-10 pt-10">
                                            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ asset('imgs/pfp.PNG') }}" alt="Vet image"/>
                                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                                {{ $vet->user->nom }} {{ $vet->user->prenom }}
                                            </h5>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $vet->nomClinique }}
                                            </span>
                                            <div class="flex mt-4 md:mt-6 mb-5">
                                                <a href="{{route('vet.profile' , $vet->id)}}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Consulter
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{route('rendez-vous.index' , $vet->id)}}" class="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full">
                                                    Rendez-vous
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                    </div>
                </div>
    </div>

    <div class="mt-10 ml-24">
        {{ $vets->withQueryString()->links('pagination.custom') }}
    </div>

@endsection
