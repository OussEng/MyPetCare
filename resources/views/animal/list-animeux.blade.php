@extends('layouts.base')

@section('content')

    <div x-data="{open: false,message: '',form: null, show(form, message) {this.form = form; this.message = message;this.open = true;}, close() { this.open = false; this.form = null; this.message = '';},
        confirm() {
            if (this.form) this.form.submit();
        }
    }"
    >
        <div class="flex justify-center mt-14 mb-96">
            <div class="w-11/12 lg:w-2/3">

                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Mes animaux
                </h1>

                <div class="mb-20">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Nom</th>
                                <th class="px-6 py-3">Espece</th>
                                <th class="px-6 py-3">Sexe</th>
                                <th class="px-6 py-3">Race</th>
                                <th class="px-6 py-3">Date de Naissance</th>
                                <th class="px-6 py-3">Poids</th>
                                <th class="px-6 py-3">Vaccinations</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                            </thead>

                            <tbody>

                            @forelse($animals as $animal)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">

                                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $animal->nom }}
                                    </th>

                                    <td class="px-6 py-4">
                                        {{ $animal->espece->libelle }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $animal->sexe->libelle }}
                                    </td>

                                    @if($animal->race)
                                        <td class="px-6 py-4">{{ $animal->race }}</td>
                                    @else
                                        <td class="px-6 py-4">Inconnue</td>
                                    @endif

                                    @if($animal->dateNaissance)
                                        <td class="px-6 py-4">{{ $animal->dateNaissance }}</td>
                                    @else
                                        <td class="px-6 py-4">Inconnue</td>
                                    @endif

                                    @if($animal->poids)
                                        <td class="px-6 py-4">{{ $animal->poids }} Kg</td>
                                    @else
                                        <td class="px-6 py-4">Inconnue</td>
                                    @endif

                                    <td class="px-6 py-4">
                                        <a href="{{ route('vaccinations', $animal->id) }}"
                                           class="text-blue-600 hover:underline">
                                            Vaccinations
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 text-right">

                                        <a href="{{ route('animaux.edit', $animal->id) }}"
                                           class="font-medium text-blue-600 hover:underline me-3">
                                            Modifier
                                        </a>

                                        <form
                                            action="{{ route('animaux.delete', $animal->id) }}"
                                            method="POST"
                                            class="inline"
                                            @submit.prevent="show($el, 'Êtes-vous sûr de vouloir supprimer {{ $animal->nom }} ?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="font-medium text-red-600 hover:underline">
                                                Supprimer
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                            @empty
                                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                                    Vous n'avez pas d'animaux
                                </div>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <a href="{{route('animaux.form')}}"
                       class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 text-sm font-medium text-gray-900 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-500 hover:text-white">
                    <span class="px-5 py-2.5 bg-white rounded-md">
                        Ajouter
                    </span>
                    </a>
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
