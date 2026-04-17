@extends('layouts.base')
@section('content')

    <div class="min-h-screen flex items-center justify-center px-4 py-16 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md">


            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-13 h-13 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 mb-5 p-3">
                    <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c2.21 0 4-1.79 4-4S14.21 3 12 3 8 4.79 8 7s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white tracking-tight">Créer un compte</h1>
                <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Choisissez votre rôle pour commencer</p>
            </div>


            <div class="flex flex-col gap-2">





                <a href="{{ route('register') }}"
                   class="group flex items-center gap-4 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-750 transition-all duration-150">
                    <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Client</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Animaux, rendez-vous, vétérinaires</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-blue-400 group-hover:translate-x-0.5 transition-all duration-150" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>


                <div class="flex items-center gap-3 px-1 my-1">
                    <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
                    <span class="text-xs text-gray-400 dark:text-gray-500">ou</span>
                    <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
                </div>


                <a href="{{ route('register_vet.form') }}"
                   class="group flex items-center gap-4 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-green-400 dark:hover:border-green-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-all duration-150">
                    <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-green-50 dark:bg-green-900/20 group-hover:bg-green-100 dark:group-hover:bg-green-900/40 transition-colors">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6"/>
                            <rect x="3" y="3" width="18" height="18" rx="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Vétérinaire</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800">
                            Pro
                        </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Backoffice · gestion clinique</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-green-500 group-hover:translate-x-0.5 transition-all duration-150" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>


                <div class="flex items-start gap-3 bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 mt-2">
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
                    </svg>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Comptes vétérinaire —</span>
                        votre inscription sera examinée par un administrateur avant activation.
                    </p>
                </div>

            </div>


            <p class="mt-8 text-center text-xs text-gray-400 dark:text-gray-500">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white underline underline-offset-2 transition-colors">
                    Se connecter
                </a>
            </p>

        </div>
    </div>

@endsection
