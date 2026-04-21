@extends('layouts.backoffice')

@section('content')

    <div x-data="{open: false,message: '',form: null,show(form, message) {this.form = form;this.message = message;this.open = true;},close() {this.open = false;this.form = null;this.message = '';},

    confirm() {
        if (this.form) this.form.submit();
    }
}">

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

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $vet->id }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $vet->user->prenom }} {{ $vet->user->nom }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $vet->user->email }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $vet->user->numero }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $vet->nomClinique }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $vet->NbAnsExperience }} ans
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $vet->numeroLicence }}
                                            </td>

                                            <td class="px-6 py-4 text-sm">

                                                @if($vet->user->deleted_at)

                                                    <form method="POST"
                                                          action="{{ route('admin.user.enable', $vet->user->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                class="text-green-600 hover:underline">
                                                            Restaurer
                                                        </button>
                                                    </form>

                                                @else

                                                    <form method="POST"
                                                          action="{{ route('admin.user.disable', $vet->user->id) }}"
                                                          @submit.prevent="show($el, 'Désactiver cet utilisateur ?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="text-red-600 hover:underline">
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

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $client->id }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $client->prenom }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $client->nom }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $client->email }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $client->numero }}
                                            </td>

                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $client->adresse }}
                                            </td>

                                            <td class="px-6 py-4 text-sm">

                                                @if($client->deleted_at)

                                                    <form method="POST"
                                                          action="{{ route('admin.user.enable', $client->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                class="text-green-600 hover:underline">
                                                            Restaurer
                                                        </button>
                                                    </form>

                                                @else

                                                    <form method="POST"
                                                          action="{{ route('admin.user.disable', $client->id) }}"
                                                          @submit.prevent="show($el, 'Désactiver ce client ?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="text-red-600 hover:underline">
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
             x-transition
             x-cloak
             class="fixed inset-0 flex items-center justify-center z-50">


            <div class="absolute inset-0 bg-black/50" @click="close()"></div>


            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md z-10">

                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Confirmation
                </h2>

                <p class="text-gray-600 mb-6" x-text="message"></p>

                <div class="flex justify-end gap-3">

                    <button type="button"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                            @click="close()">
                        Annuler
                    </button>

                    <button type="button"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                            @click="confirm()">
                        Confirmer
                    </button>

                </div>
            </div>
        </div>

    </div>

@endsection
