@extends('layouts.backoffice')

@section('content')

    <div class="ml-72">
        <h1 class="mt-10 mb-10 text-3xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Mon <span
                class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600 ">profile</span>
        </h1>
        <div class="flex flex-col gap-10">
            <div class="flex justify-around">
                <div class="w-1/6 flex justify-center">
                    <div
                        class="bg-white shadow rounded-lg border w-full flex flex-col items-center p-2 self-start h-60">
                        <img
                            class="rounded-full w-32 h-32 object-cover object-center ring-4 ring-indigo-500 ring-offset-2"
                            src="{{asset('imgs/pfp.png')}}" alt="pfp">
                    </div>
                </div>
                <div class="w-1/3">

                    <div class="bg-white overflow-hidden shadow rounded-lg border">
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Rôle
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        Vétérinaire
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Nom et prénom
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->user->nom}} {{$vet->user->prenom}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Address mail
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->user->email}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Numero de telephone
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->user->numero}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Address Postal
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->user->adresse}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Date de naissance
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->dateDeNaissance}}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>
                <div class="w-1/3">
                    <div class="bg-white overflow-hidden shadow rounded-lg border">
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Clinique
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->nomClinique}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Address Clinique
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->adresseClinique}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Experience
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->NbAnsExperience}}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Certification
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->certification}}
                                    </dd>
                                </div>

                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Numero de licence
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->numeroLicence}}
                                    </dd>
                                </div>

                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Date d'expiration
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$vet->licenceExpiration}}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>


                </div>
            </div>
            <div
                x-data="{ showLanguagesModal: false }"
                x-cloak @keydown.escape="showLanguagesModal = false">

                <div class="w-1/3">
                    <div class="bg-white overflow-hidden shadow rounded-lg border">
                        <div class="py-3 sm:py-5 sm:px-6">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 border-r-2">
                                    Langues
                                </dt>
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


                <div
                    x-show="showLanguagesModal"
                    x-transition
                    class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
                >
                    <div
                        @click.away="showLanguagesModal = false"
                        class="bg-white rounded-lg p-6 w-1/3"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold">Ajouter des langues:</h3>
                            <button @click="showLanguagesModal = false">&times;</button>
                        </div>

                        <div>

                            <form action="{{ route("veterinaire.add-langues")}}" method="POST">
                                @csrf

                                @foreach($langues as $langue)
                                    <div class="flex items-center px-4 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
                                        <label for="{{$langue->libelle}}" class="select-none w-full py-4 ms-2 text-sm font-medium text-heading">
                                            {{$langue->libelle}}
                                        </label>
                                        <input
                                            id="{{$langue->libelle}}"
                                            type="checkbox"
                                            value="{{$langue->id}}"
                                            name="langues[]"
                                            class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"
                                            @if($vet->langues->contains($langue)) checked @endif
                                        >
                                    </div>
                                @endforeach
                                    <button type="submit"
                                            class="text-white bg-gray-800 mt-5 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                        Terminer
                                    </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
