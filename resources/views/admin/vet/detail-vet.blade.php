@extends('layouts.backoffice')
@section('content')

    <div
        x-data="{ showAcceptModal: false, showRefuseModal: false }"
        @keydown.escape.window="showAcceptModal = false; showRefuseModal = false"
        class="py-12"
    >
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">


            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Détails du Vétérinaire</h1>
                <div class="ml-2 xl:ml-32 mt-10">
                    <a href="{{route('admin.pending-vets')}}"
                       class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">


                    <div class="flex items-center mb-8 pb-8 border-b border-gray-200">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 mr-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $vet->user->nom }} {{ $vet->user->prenom }}</h1>
                            <p class="text-lg text-gray-600 mt-1">{{ $vet->nomClinique }}</p>
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations Personnelles</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nom</p>
                                    <p class="text-lg text-gray-900">{{ $vet->user->nom }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Prénom</p>
                                    <p class="text-lg text-gray-900">{{ $vet->user->prenom }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="text-lg text-gray-900">{{ $vet->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                    <p class="text-lg text-gray-900">{{ $vet->user->numero }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date de Naissance</p>
                                    <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($vet->dateDeNaissance)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Adresse</p>
                                    <p class="text-lg text-gray-900">{{ $vet->user->adresse }}</p>
                                </div>
                            </div>
                        </div>


                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations Professionnelles</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Clinique</p>
                                    <p class="text-lg text-gray-900">{{ $vet->nomClinique }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Adresse Clinique</p>
                                    <p class="text-lg text-gray-900">{{ $vet->adresseClinique }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Numéro de Licence</p>
                                    <p class="text-lg text-gray-900">{{ $vet->numeroLicence }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Certification</p>
                                    <p class="text-lg text-gray-900">{{ $vet->certification }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Années d'Expérience</p>
                                    <p class="text-lg text-gray-900">{{ $vet->NbAnsExperience }} ans</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Expiration Licence</p>
                                    <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($vet->licenceExpiration)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if($vet->langues->count() > 0)
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Langues Parlées</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($vet->langues as $langue)
                                    <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $langue->libelle }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="flex gap-4">
                            <button
                                @click="showAcceptModal = true"
                                class="inline-flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            <button
                                @click="showRefuseModal = true"
                                class="inline-flex items-center justify-center w-12 h-12 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div
            x-show="showAcceptModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
        >
            <div
                @click.away="showAcceptModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Confirmation d'acceptation</h3>
                    <button @click="showAcceptModal = false" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </div>

                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir accepter le vétérinaire
                    <strong>{{ $vet->user->prenom }} {{ $vet->user->nom }}</strong> ?
                </p>

                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Important</p>
                            <p class="text-sm">Veuillez contacter {{ $vet->user->prenom }} {{ $vet->user->nom }} par email : <a href="mailto:{{$vet->user->email}}" class="text-blue-600 hover:underline"><strong>{{$vet->user->email}}</strong></a> ou par téléphone <strong>{{$vet->user->numero}}</strong> pour l'informer de votre décision.</p>                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <form method="POST" action="{{ route('admin.vet.accept', $vet->id) }}" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirmer
                        </button>
                    </form>
                    <button
                        @click="showAcceptModal = false"
                        class="text-gray-800 bg-white hover:bg-gray-100 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>


        <div
            x-show="showRefuseModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
        >
            <div
                @click.away="showRefuseModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Confirmation de refus</h3>
                    <button @click="showRefuseModal = false" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </div>

                <p class="text-gray-700 mb-6">
                    Êtes-vous sûr de vouloir refuser le vétérinaire
                    <strong>{{ $vet->user->nom }} {{ $vet->user->prenom }}</strong> ?
                </p>

                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Important</p>
                            <p class="text-sm">Merci de Contacter {{ $vet->user->nom }} {{ $vet->user->prenom }} par mail : <a href={{$vet->user->email}}><strong>{{$vet->user->email}}</strong></a> ou par téléphone {{$vet->user->numero}} pour les informer de votre decition</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <form method="POST" action="{{ route('admin.vet.reject', $vet->id) }}" class="inline-block">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Confirmer
                        </button>
                    </form>
                    <button
                        @click="showRefuseModal = false"
                        class="text-gray-800 bg-white hover:bg-gray-100 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
