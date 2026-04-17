@extends('layouts.base')
@section('content')

    <div class="flex justify-center mb-96 mt-52">
        <div class="w-11/12 lg:w-1/2 bg-white text-gray-500 mx-4 md:p-6 p-4 text-left text-sm rounded-xl shadow-[0px_0px_10px_0px] shadow-black/10">
            <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Inscription Client</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Prenom -->
                <div>
                    <x-input-label for="name" :value="__('Prenom')"/>
                    <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')"
                                   autofocus autocomplete="prenom"/>
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2"/>
                </div>

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('Nom')"/>
                    <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')"
                                  autofocus autocomplete="nom"/>
                    <x-input-error :messages="$errors->get('nom')" class="mt-2"/>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                   autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                   autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation"  autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <!-- Numero -->
                <div class="mt-4">
                    <x-input-label for="numero" :value="__('Numero Tel')"/>
                    <x-text-input id="numero" class="block mt-1 w-full" type="text" name="numero" :value="old('numero')"
                                   autocomplete="numero"/>
                    <x-input-error :messages="$errors->get('numero')" class="mt-2"/>
                </div>

                <!-- adresse -->
                <div>
                    <x-input-label for="adresse" :value="__('Adresse')"/>
                    <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse"
                                  :value="old('adresse')"  autofocus autocomplete="adresse"/>
                    <x-input-error :messages="$errors->get('adresse')" class="mt-2"/>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('login') }}">
                        {{ __('Déjà un compte ?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __("S'inscrire") }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
