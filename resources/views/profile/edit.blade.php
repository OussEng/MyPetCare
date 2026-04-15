@extends('layouts.base')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <h1 class="mb-8 text-3xl font-bold tracking-tight text-gray-900">
            Mon <span class="underline underline-offset-3 decoration-8 decoration-blue-400">profil</span>
        </h1>

        <div class="space-y-6">

            <div class="bg-white shadow rounded-lg border overflow-hidden"
                 x-data="{ editInfo: {{ $errors->any() && !$errors->updatePassword->any() ? 'true' : 'false' }} }"
                 @keydown.escape.window="editInfo = false"
                 x-cloak>

                <div class="px-6 py-4 flex items-center justify-between border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Informations personnelles</h2>
                    <button @click="editInfo = true" x-show="!editInfo"
                            class="text-sm text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium px-4 py-2 rounded">
                        Modifier
                    </button>
                </div>

                <div x-show="!editInfo" class="border-t border-gray-100 px-6 py-5">
                    <dl class="divide-y divide-gray-100">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Prénom</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->prenom }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Nom</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->nom }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Adresse mail</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Numéro de téléphone</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->numero }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Adresse postale</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->adresse }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Edit form --}}
                <div x-show="editInfo" x-transition class="px-6 py-5">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="prenom" value="Prénom" />
                                <x-text-input id="prenom" name="prenom" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('prenom', $user->prenom)" required />
                                <x-input-error :messages="$errors->get('prenom')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="nom" value="Nom" />
                                <x-text-input id="nom" name="nom" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('nom', $user->nom)" required />
                                <x-input-error :messages="$errors->get('nom')" class="mt-1" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="email" value="Adresse mail" />
                            <x-text-input id="email" name="email" type="email"
                                          class="mt-1 block w-full"
                                          :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="numero" value="Numéro de téléphone" />
                            <x-text-input id="numero" name="numero" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('numero', $user->numero)" required />
                            <x-input-error :messages="$errors->get('numero')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="adresse" value="Adresse postale" />
                            <x-text-input id="adresse" name="adresse" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('adresse', $user->adresse)" required />
                            <x-input-error :messages="$errors->get('adresse')" class="mt-1" />
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <x-primary-button>Enregistrer</x-primary-button>
                            <button type="button" @click="editInfo = false"
                                    class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg border overflow-hidden"
                 x-data="{ editPwd: {{ $errors->updatePassword->any() ? 'true' : 'false' }} }"
                 @keydown.escape.window="editPwd = false"
                 x-cloak>

                <div class="px-6 py-4 flex items-center justify-between border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Mot de passe</h2>
                    <button @click="editPwd = true" x-show="!editPwd"
                            class="text-sm text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium px-4 py-2 rounded">
                        Changer le mot de passe
                    </button>
                </div>

                <div x-show="!editPwd" class="px-6 py-5">
                    <p class="text-sm text-gray-500">Cliquez sur le bouton pour changer votre mot de passe.</p>
                </div>

                <div x-show="editPwd" x-transition class="px-6 py-5">
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="current_password" value="Mot de passe actuel" />
                            <x-text-input id="current_password" name="current_password" type="password"
                                          class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Nouveau mot de passe" />
                            <x-text-input id="password" name="password" type="password"
                                          class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Confirmer le nouveau mot de passe" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                          class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <x-primary-button>Enregistrer</x-primary-button>
                            <button type="button" @click="editPwd = false"
                                    class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

