@extends('layouts.base')

@section('content')
    <div class="relative w-full min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('imgs/background-cat.jpg') }}');">


    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-8 text-center" style="text-shadow: -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white, 1px 1px 0 white;">
            Mes Rendez-vous
        </h1>


    @forelse($rendezvous as $rdv)
            <div class="mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700 transition hover:shadow-lg">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                                    Rendez-vous pour {{ $rdv->animal->nom }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Avec Dr. {{ $rdv->veterinaire->user->nom }} | Le {{ \Carbon\Carbon::parse($rdv->dateHeureDebut)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-gray-700 dark:text-gray-300">
                        <p class="mb-2"><span class="font-semibold">Motif:</span> {{ $rdv->motif }}</p>
                        <a href="{{ route('vet.profile', $rdv->veterinaire->id) }}" class="text-blue-600 hover:underline font-medium flex items-center text-sm">
                            Voir le profil du vétérinaire
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-600 dark:text-gray-400 mt-10">
                Aucun rendez-vous pour le moment.
            </div>
        @endforelse
    </div>
    </div>
@endsection
