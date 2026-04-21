@extends('layouts.backoffice')
@section('content')
    <div class="p-8 space-y-8 max-w-5xl mx-auto">

        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Accueil</h1>
            <p class="text-sm text-gray-500 mt-1">Gestion du backoffice</p>
        </div>


        <div class="space-y-4">

            <a href="{{ route('admin.pending-vets') }}"
               class="group w-full flex items-center justify-between p-6 bg-white border rounded-xl shadow-sm hover:shadow-md hover:border-orange-300 transition">

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-800">Vétérinaires en attente</h2>
                        <p class="text-sm text-gray-500">Valider ou refuser les demandes</p>
                    </div>
                </div>

                <span class="text-sm text-gray-400 group-hover:translate-x-1 transition">

        </span>
            </a>

            <a href="{{ route('admin.users') }}"
               class="group w-full flex items-center justify-between p-6 bg-white border rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 transition">

                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5V4H2v16h5m10 0v-6a4 4 0 10-8 0v6m8 0H9"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-800">Utilisateurs</h2>
                        <p class="text-sm text-gray-500">Voir et gérer les comptes</p>
                    </div>
                </div>

                <span class="text-sm text-gray-400 group-hover:translate-x-1 transition">

        </span>
            </a>

        </div>

    </div>


@endsection
