@extends('layouts.backoffice')

@section('content')

    <div class="ml-72"
         x-data="{
             showLanguagesModal: false,
             showEditInfoModal: false,
             showEditVetModal: false
         }"
         x-cloak
         @keydown.escape.window="showLanguagesModal = false; showEditInfoModal = false; showEditVetModal = false">

        <h1 class="mt-10 mb-10 text-3xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Mon <span
                class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600">profile</span>
        </h1>

        <div class="flex flex-col gap-10">
            <div class="flex justify-around">

                <div class="w-1/6 flex justify-center">
                    <div class="bg-white shadow rounded-lg border w-full flex flex-col items-center p-2 self-start h-60">
                        <img class="rounded-full w-32 h-32 object-cover object-center ring-4 ring-indigo-500 ring-offset-2"
                             src="{{ asset('imgs/pfp.png') }}" alt="pfp">
                    </div>
                </div>

                <div class="w-1/3">
                    <div class="bg-white overflow-hidden shadow rounded-lg border">
                        <div class="flex items-center justify-between px-6 py-3 border-b">
                            <span class="text-sm font-semibold text-gray-700">Informations personnelles</span>
                            <button @click="showEditInfoModal = true"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-xs px-3 py-1.5">
                                Modifier
                            </button>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Rôle</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Vétérinaire</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Nom et prénom</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $vet->user->nom }} {{ $vet->user->prenom }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Adresse mail</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->user->email }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Numéro de téléphone</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->user->numero }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Adresse postale</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->user->adresse }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Date de naissance</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->dateDeNaissance }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="w-1/3">
                    <div class="bg-white overflow-hidden shadow rounded-lg border">
                        <div class="flex items-center justify-between px-6 py-3 border-b">
                            <span class="text-sm font-semibold text-gray-700">Informations professionnelles</span>
                            <button @click="showEditVetModal = true"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-xs px-3 py-1.5">
                                Modifier
                            </button>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Clinique</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->nomClinique }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Adresse clinique</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->adresseClinique }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Expérience</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->NbAnsExperience }} ans</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Certification</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->certification }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Numéro de licence</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->numeroLicence }}</dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Date d'expiration</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $vet->licenceExpiration }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-1/3">
                <div class="bg-white overflow-hidden shadow rounded-lg border">
                    <div class="py-3 sm:py-5 sm:px-6">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500 border-r-2">Langues</dt>
                            <dd class="mt-1 sm:mt-0 sm:col-span-2 space-y-1">
                                @forelse($vet->langues as $langue)
                                    <p class="text-sm text-gray-900">{{ $langue->libelle }}</p>
                                @empty
                                    <p class="text-sm text-gray-900">Vous n'avez pas encore ajouté des langues</p>
                                @endforelse
                            </dd>
                        </div>
                        <div class="flex justify-end mt-3">
                            <button @click="showLanguagesModal = true"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5">
                                Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div x-show="showEditInfoModal"
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
            <div @click.away="showEditInfoModal = false"
                 class="bg-white rounded-lg p-6 w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Modifier mes informations</h3>
                    <button @click="showEditInfoModal = false" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                </div>

                <form action="{{ route('veterinaire.profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nomClinique"     value="{{ $vet->nomClinique }}">
                    <input type="hidden" name="adresseClinique" value="{{ $vet->adresseClinique }}">
                    <input type="hidden" name="NbAnsExperience" value="{{ $vet->NbAnsExperience }}">
                    <input type="hidden" name="dateDeNaissance" value="{{ $vet->dateDeNaissance }}">
                    <input type="hidden" name="certification"   value="{{ $vet->certification }}">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $vet->user->prenom) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom', $vet->user->nom) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse mail</label>
                        <input type="email" name="email" value="{{ old('email', $vet->user->email) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                        <input type="text" name="numero" value="{{ old('numero', $vet->user->numero) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('numero') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse postale</label>
                        <input type="text" name="adresse" value="{{ old('adresse', $vet->user->adresse) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('adresse') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showEditInfoModal = false"
                                class="text-sm text-gray-600 hover:text-gray-900 underline">Annuler</button>
                        <button type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showEditVetModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
        >

            <div @click.away="showEditVetModal = false"
                 class="bg-white rounded-lg p-6 w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg">Modifier les informations professionnelles</h3>
                    <button @click="showEditVetModal = false" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                </div>

                <form action="{{ route('veterinaire.profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="prenom"  value="{{ $vet->user->prenom }}">
                    <input type="hidden" name="nom"     value="{{ $vet->user->nom }}">
                    <input type="hidden" name="email"   value="{{ $vet->user->email }}">
                    <input type="hidden" name="numero"  value="{{ $vet->user->numero }}">
                    <input type="hidden" name="adresse" value="{{ $vet->user->adresse }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom de la clinique</label>
                        <input type="text" name="nomClinique" value="{{ old('nomClinique', $vet->nomClinique) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('nomClinique') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse de la clinique</label>
                        <input type="text" name="adresseClinique" value="{{ old('adresseClinique', $vet->adresseClinique) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('adresseClinique') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Années d'expérience</label>
                        <input type="number" name="NbAnsExperience" value="{{ old('NbAnsExperience', $vet->NbAnsExperience) }}" min="0" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('NbAnsExperience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" name="dateDeNaissance" value="{{ old('dateDeNaissance', $vet->dateDeNaissance) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('dateDeNaissance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Certification</label>
                        <input type="text" name="certification" value="{{ old('certification', $vet->certification) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('certification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showEditVetModal = false"
                                class="text-sm text-gray-600 hover:text-gray-900 underline">Annuler</button>
                        <button type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showLanguagesModal"
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
             <div @click.away="showLanguagesModal = false"
                 class="bg-white rounded-lg p-6 w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold">Ajouter des langues:</h3>
                    <button @click="showLanguagesModal = false">&times;</button>
                </div>
                <div>
                    <form action="{{ route('veterinaire.add-langues') }}" method="POST">
                        @csrf
                        @foreach($langues as $langue)
                            <div class="flex items-center px-4 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
                                <label for="{{ $langue->libelle }}" class="select-none w-full py-4 ms-2 text-sm font-medium text-heading">
                                    {{ $langue->libelle }}
                                </label>
                                <input id="{{ $langue->libelle }}"
                                       type="checkbox"
                                       value="{{ $langue->id }}"
                                       name="langues[]"
                                       class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"
                                       @if($vet->langues->contains($langue)) checked @endif>
                            </div>
                        @endforeach
                        <button type="submit"
                                class="text-white bg-gray-800 mt-5 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2">
                            Terminer
                        </button>
                    </form>
                </div>
            </div>
        </>

    </div>

@endsection
