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

    <div class="flex justify-center mt-20 gap-5">
        @if ($current_appointment)
        <div class="max-w-80 w-full transition delay-100 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110">
            <div class="pt-3 overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-md shadow-lg">
                <h1 class="text-gray-900 text-xl font-semibold pl-6 pb-2">Rendez Vous Actuel:</h1>

                <div class="bg-white pb-6 pt-4 px-6 text-sm">
                    <p class="text-gray-600 font-medium mb-3">
                        <span class="text-blue-600 font-bold">{{ \Carbon\Carbon::parse($current_appointment->dateHeureDebut)->format('H:i') }}</span>
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Animal:</strong> {{ $current_appointment->animal->nom ?? 'N/A' }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Client:</strong> {{ $current_appointment->user->nom ?? 'N/A' }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Motif:</strong> {{ $current_appointment->motif ?? 'N/A' }}
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-semibold">
                        {{ $current_appointment->etat->name }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        @if ($next_appointment)
        <div class="max-w-80 w-full transition delay-100 duration-300 ease-in-out hover:-translate-y-1 hover:scale-110">
            <div class="pt-3 overflow-hidden bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 rounded-md shadow-lg">
                <h1 class="text-gray-900 text-xl font-semibold pl-6 pb-2">Prochain Rendez Vous:</h1>

                <div class="bg-white pb-6 pt-4 px-6 text-sm">
                    <p class="text-gray-600 font-medium mb-3">
                        <span class="text-green-600 font-bold">{{ \Carbon\Carbon::parse($next_appointment->dateHeureDebut)->format('d/m H:i') }}</span>
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Animal:</strong> {{ $next_appointment->animal->nom ?? 'N/A' }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Client:</strong> {{ $next_appointment->user->nom ?? 'N/A' }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Motif:</strong> {{ $next_appointment->motif ?? 'N/A' }}
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-semibold">
                        {{ $next_appointment->etat->name }}
                    </span>
                </div>
            </div>
        </div>
        @endif

        @if (!$current_appointment && !$next_appointment)
        <div class="max-w-80 w-full">
            <div class="pt-3 overflow-hidden bg-gray-100 border border-gray-200 rounded-md shadow">
                <h1 class="text-gray-900 text-xl font-semibold pl-6 pb-3">Aucun Rendez Vous</h1>
                <div class="text-gray-600 bg-white pb-3 pt-6 text-sm flex justify-center">
                    <p>Pas de rendez-vous prévu pour le moment</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    </div>


@endsection
