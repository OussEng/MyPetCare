@extends('layouts.base')

@section('content')

    <div x-data="{open: false, message: '', form: null,
    show(form, message) { this.form = form; this.message = message; this.open = true; },
    close() { this.open = false; this.form = null; this.message = ''; },
    confirm() { if (this.form) this.form.submit(); }
    }"
         @keydown.escape.window="close()"
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
                                <th class="px-6 py-3">Age</th>
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
                                        <td class="px-6 py-4">{{ $animal->age() }} ans</td>
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
                    <a
                        href="{{route('animaux.form')}}"
                        class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                                        <span
                                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent">
                                        Ajouter un animal
                                        </span>
                    </a>
                </div>

            </div>
        </div>


        <div
            x-show="open"
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
                    <button @click="close()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </div>

                <p class="text-gray-700 mb-6" x-text="message"></p>

                <div class="flex gap-3 justify-end">
                    <button
                        type="button"
                        class="text-gray-800 bg-white hover:bg-gray-100 border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors"
                        @click="close()">
                        Annuler
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors"
                        @click="confirm()">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>

@endsection
