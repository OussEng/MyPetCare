@extends('layouts.backoffice')

@section('content')

    <div class="ml-64"
         x-data="{
            open: false, message: '', form: null, isDanger: true,
            show(form, message, danger = true) { this.form = form; this.message = message; this.isDanger = danger; this.open = true; },
            close() { this.open = false; this.form = null; this.message = ''; this.isDanger = true; },
            confirm() { if (this.form) this.form.submit(); }
         }"
         @keydown.escape.window="close()"
    >

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">


                        <h1 class="text-3xl font-bold mb-6 text-gray-800">Vétérinaires</h1>

                        @if($vets->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-gray-500 text-lg">Aucun vétérinaire trouvé.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                                    <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Téléphone</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clinique</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Expérience</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Licence</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($vets as $vet)
                                        <tr class="hover:bg-gray-50 transition-colors {{ $vet->user->deleted_at ? 'opacity-50' : '' }}">

                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $vet->id }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $vet->user->prenom }} {{ $vet->user->nom }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $vet->user->email }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $vet->user->numero }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $vet->nomClinique }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $vet->NbAnsExperience }} ans</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $vet->numeroLicence }}</td>

                                            <td class="px-6 py-4 text-sm">

                                                @if($vet->user->deleted_at)
                                                    <form method="POST"
                                                          action="{{ route('admin.vet.enable', $vet->id) }}"
                                                          @submit.prevent="show($el, 'Restaurer le vétérinaire {{ $vet->user->prenom }} {{ $vet->user->nom }} ?', false)">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:underline">
                                                            Restaurer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                          action="{{ route('admin.vet.disable', $vet->id) }}"
                                                          @submit.prevent="show($el, 'Désactiver le vétérinaire {{ $vet->user->prenom }} {{ $vet->user->nom }} ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline">
                                                            Désactiver
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @endif

                        <div class="mt-4">
                            {{ $vets->appends(request()->query())->links('pagination.custom') }}
                        </div>


                        <h1 class="text-3xl font-bold mt-16 mb-6 text-gray-800">Clients</h1>

                        @if($clients->isEmpty())
                            <div class="text-center py-12">
                                <p class="text-gray-500 text-lg">Aucun client trouvé.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">

                                    <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Prénom</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Téléphone</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Adresse</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($clients as $client)
                                        <tr class="hover:bg-gray-50 transition-colors {{ $client->deleted_at ? 'opacity-50' : '' }}">

                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $client->id }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $client->prenom }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $client->nom }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $client->email }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $client->numero }}</td>

                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $client->adresse }}</td>

                                            <td class="px-6 py-4 text-sm">

                                                @if($client->deleted_at)
                                                    <form method="POST"
                                                          action="{{ route('admin.user.enable', $client->id) }}"
                                                          @submit.prevent="show($el, 'Restaurer le client {{ $client->prenom }} {{ $client->nom }} ?', false)">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:underline">
                                                            Restaurer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                          action="{{ route('admin.user.disable', $client->id) }}"
                                                          @submit.prevent="show($el, 'Désactiver le client {{ $client->prenom }} {{ $client->nom }} ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline">
                                                            Désactiver
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @endif

                        <div class="mt-4">
                            {{ $clients->appends(request()->query())->links('pagination.custom') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
        >
            <div
                @click.away="close()"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4"
            >
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Confirmation</h2>
                    <button type="button" @click="close()"
                            class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </div>

                <p class="text-gray-700 mb-6" x-text="message"></p>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            @click="close()"
                            class="text-gray-800 bg-white hover:bg-gray-100 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        Annuler
                    </button>

                    <button type="button"
                            @click="confirm()"
                            :class="isDanger
                                ? 'bg-red-600 hover:bg-red-700 focus:ring-red-300'
                                : 'bg-green-600 hover:bg-green-700 focus:ring-green-300'"
                            class="inline-flex items-center text-white focus:outline-none focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  x-show="isDanger"
                                  d="M6 18L18 6M6 6l12 12"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  x-show="!isDanger"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                        <span x-text="isDanger ? 'Confirmer' : 'Restaurer'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>

@endsection
