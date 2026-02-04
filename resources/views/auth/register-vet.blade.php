@extends('layouts.base')
@section('content')

    <div class="flex justify-center">
        <div class="w-1/2">

            <form method="POST" action="{{ route('register_vet.save') }}">
                @csrf

                <!-- Prenom -->
                <div>
                    <x-input-label for="name" :value="__('Prenom')"/>
                    <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')"
                                  required autofocus autocomplete="prenom"/>
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2"/>
                </div>

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('nom')"/>
                    <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required
                                  autofocus autocomplete="nom"/>
                    <x-input-error :messages="$errors->get('nom')" class="mt-2"/>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <!-- Numero -->
                <div class="mt-4">
                    <x-input-label for="numero" :value="__('Tel')"/>
                    <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" :value="old('numero')"
                                  required autocomplete="numero"/>
                    <x-input-error :messages="$errors->get('numero')" class="mt-2"/>
                </div>

                <!-- Adresse -->
                <div>
                    <x-input-label for="adresse" :value="__('adresse Postal')"/>
                    <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse"
                                  :value="old('adresse')" required autofocus autocomplete="adresse"/>
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2"/>
                </div>

                <div>
                    <div>
                        <x-input-label for="numeroLicence" :value="__('Numero de Licence')"/>
                        <x-text-input id="numeroLicence" class="block mt-1 w-full" type="text" name="numeroLicence"
                                      :value="old('numeroLicence')" required autofocus autocomplete="numeroLicence"/>
                        <x-input-error :messages="$errors->get('numeroLicence')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="nomClinique" :value="__('Nom de Clinique')"/>
                        <x-text-input id="nomClinique" class="block mt-1 w-full" type="text" name="nomClinique"
                                      :value="old('nomClinique')" required autofocus autocomplete="nomClinique"/>
                        <x-input-error :messages="$errors->get('nomClinique')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="NbAnsExperience" :value="__('Experience (ans)')"/>
                        <x-text-input id="NbAnsExperience" class="block mt-1 w-full" type="number"
                                      name="NbAnsExperience" :value="old('NbAnsExperience')" required autofocus
                                      autocomplete="NbAnsExperience"/>
                        <x-input-error :messages="$errors->get('NbAnsExperience')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="certification" :value="__('Certification')"/>
                        <x-text-input id="certification" class="block mt-1 w-full" type="text" name="certification"
                                      :value="old('certification')" required autofocus autocomplete="certification"/>
                        <x-input-error :messages="$errors->get('certification')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="dateDeNaissance" :value="__('Date de Naissance')"/>
                        <x-text-input id="dateDeNaissance" class="block mt-1 w-full" type="date" name="dateDeNaissance"
                                      :value="old('dateDeNaissance')" required autofocus
                                      autocomplete="dateDeNaissance"/>
                        <x-input-error :messages="$errors->get('certification')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="licenceExpiration" :value="__('Date expiration de licence')"/>
                        <x-text-input id="licenceExpiration" class="block mt-1 w-full" type="date"
                                      name="licenceExpiration" :value="old('licenceExpiration')" required autofocus
                                      autocomplete="licenceExpiration"/>
                        <x-input-error :messages="$errors->get('certification')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="horaires" :value="__('Horaires')"/>
                        <x-text-input id="horaires" class="block mt-1 w-full" type="text" name="horaires"
                                      :value="old('horaires')" required autofocus autocomplete="horaires"/>
                        <x-input-error :messages="$errors->get('certification')" class="mt-2"/>
                    </div>

                </div>
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
@endsection
