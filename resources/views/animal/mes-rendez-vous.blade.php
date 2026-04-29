@extends('layouts.base')

@section('content')
    <div
        x-data="{ showCancelModal: false, cancelRdvId: null }"
        @keydown.escape.window="showCancelModal = false; cancelRdvId = null"
        class="relative w-full min-h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('imgs/background-cat.jpg') }}');"
    >

    <div class="max-w-5xl mx-auto px-4 pb-16">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-8 text-center pt-8" style="text-shadow: -1px -1px 0 white, 1px -1px 0 white, -1px 1px 0 white, 1px 1px 0 white;">
            Mes Rendez-vous
        </h1>

        <div class="flex flex-wrap justify-between gap-2 mb-4">

            <a href="{{ route('rendez-vous.list', ['etat' => 'tous']) }}"
               class="flex-1 min-w-[100px] text-center text-sm text-white active:scale-95 transition-all h-10 rounded-md flex items-center justify-center
               {{ !request()->get('jour') && request()->get('etat') === 'tous' ? 'bg-indigo-800 ring-2 ring-indigo-300' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                Tous
            </a>
            <a href="{{ route('rendez-vous.list', ['etat' => 'confirmé']) }}"
               class="flex-1 min-w-[100px] text-center text-sm text-white active:scale-95 transition-all h-10 rounded-md flex items-center justify-center
               {{ !request()->get('jour') && (request()->get('etat') === 'confirmé' || !request()->get('etat')) ? 'bg-indigo-800 ring-2 ring-indigo-300' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                Confirmés
            </a>
            <a href="{{ route('rendez-vous.list', ['etat' => 'terminé']) }}"
               class="flex-1 min-w-[100px] text-center text-sm text-white active:scale-95 transition-all h-10 rounded-md flex items-center justify-center
               {{ !request()->get('jour') && request()->get('etat') === 'terminé' ? 'bg-indigo-800 ring-2 ring-indigo-300' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                Terminés
            </a>
            <a href="{{ route('rendez-vous.list', ['etat' => 'annulé']) }}"
               class="flex-1 min-w-[100px] text-center text-sm text-white active:scale-95 transition-all h-10 rounded-md flex items-center justify-center
               {{ !request()->get('jour') && request()->get('etat') === 'annulé' ? 'bg-indigo-800 ring-2 ring-indigo-300' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                Annulés
            </a>
        </div>

        <div class="flex justify-center mb-8">
            <a href="{{ route('rendez-vous.list', ['jour' => "aujourd'hui"]) }}"
               class="w-48 text-center text-sm text-white active:scale-95 transition-all h-10 rounded-md flex items-center justify-center
               {{ request()->get('jour') ? 'bg-green-800 ring-2 ring-green-300' : 'bg-green-600 hover:bg-green-700' }}">
                Aujourd'hui
            </a>
        </div>

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

                    <div class="mt-3 sm:mt-0">
                        @if($rdv->etat->isConfirmed())
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-300">{{ $rdv->etat }}</span>
                        @elseif($rdv->etat->isFinished())
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-300">{{ $rdv->etat }}</span>
                        @elseif($rdv->etat->isCancelled())
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-300">{{ $rdv->etat }}</span>
                        @endif
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

                @if(!$rdv->etat->isCancelled() && !$rdv->etat->isFinished())
                <div class="flex justify-start sm:justify-end mt-4">
                    <button
                        type="button"
                        @click="cancelRdvId = {{ $rdv->id }}; showCancelModal = true"
                        class="px-6 py-2 active:scale-95 transition text-red-500 text-sm font-medium border-2 border-red-500 hover:bg-red-50">
                        Annuler
                    </button>
                </div>
                @endif
            </div>
        </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Aucun rendez-vous trouvé.</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $rendezvous->withQueryString()->links('pagination.custom') }}
        </div>
    </div>

    <div
        x-show="showCancelModal"
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
            @click.away="showCancelModal = false; cancelRdvId = null"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl"
        >
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg text-gray-800">Confirmer l'annulation</h3>
                <button @click="showCancelModal = false; cancelRdvId = null" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>

            <p class="text-gray-700 mb-6">
                Êtes-vous sûr de vouloir annuler ce rendez-vous ? Cette action est irréversible.
            </p>

            <div class="bg-red-50 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md mb-5" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Attention</p>
                        <p class="text-sm">Le vétérinaire sera informé de l'annulation. Pensez à le contacter si nécessaire.</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <form method="POST" :action="`/mes-rendez-vous/${cancelRdvId}/cancel`">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Confirmer l'annulation
                    </button>
                </form>
                <button
                    type="button"
                    @click="showCancelModal = false; cancelRdvId = null"
                    class="text-gray-800 bg-white hover:bg-gray-100 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                    Retour
                </button>
            </div>
        </div>
    </div>

    </div>
@endsection

