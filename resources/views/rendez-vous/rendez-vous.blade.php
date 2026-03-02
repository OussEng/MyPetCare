@extends('layouts.base')

@section('content')

    <div class="flex justify-center mt-14 mb-96">
        <div class="w-11/12 lg:w-1/2">
            <h1 class="mb-4 xl:text-4xl font-extrabold leading-none tracking-tight text-gray-900 text-3xl dark:text-white">Prendre un rendez-vous avec <span class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600">{{$data['vet']->user->nom}} {{$data['vet']->user->prenom}}</span></h1>


                    <form method="GET" action="{{ route('rendez-vous.index', ['id' => $data['vet']->id]) }}">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Choisissez une date :</label>
                            <input
                                type="date"
                                name="date"
                                id="date"
                                value="{{ $data['selectedDate'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm mb-5"
                            >
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-16"
                            >
                                Voir les créneaux
                            </button>
                        </div>
                    </form>

                    @isset($data['selectedDate'])
                        <div class="border-gray-600 rounded border-solid border-2 p-5 mb-10">
                            <form method="POST" action="{{ route('rendez-vous.store', ['id' => $data['vet']->id]) }}">
                                @csrf
                                <label for="espece" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">C'est pour qui ? :</label>
                                <select id="animal_id" name="animal_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                                    <option disabled selected value="">Sélectionnez votre animal</option>
                                    @if(empty(!$data['animaux']))
                                        <option class="bg-orange-500">Vous n'avez pas d'animaux !</option>
                                    @endif

                                    @foreach($data['animaux'] as $animal)
                                        <option value="{{ $animal->id }}" >{{$animal->nom}}</option>
                                    @endforeach
                                </select>

                                @if(empty(!$data['animaux']))
                                    <div class="flex justify-center">
                                    <a href="{{route('animaux.form')}}" class="m-8 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                        Ajouter un animal
                                    </a>
                                    </div>
                                @endif


                                <label for="motif" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison ? :</label>
                                <input type="text" id="motif" name="motif"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 mb-5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Motif de rendez-vous..." required/>
                                <ul class="grid w-full gap-6 md:grid-cols-2">
                                @forelse($data['slots'] as $slot)
                                        <li>
                                            <input type="radio" id="slot-{{ $loop->index }}" name="dateHeureDebut" value="{{ $slot }}" class="hidden peer" required />
                                            <label for="slot-{{ $loop->index }}" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <div class="block">
                                                    <div class="w-full text-lg font-semibold">{{ \Carbon\Carbon::parse($slot)->format('H:i') }}</div>
                                                </div>
                                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                                </svg>
                                            </label>
                                        </li>
                                @empty
                                    <p>Aucun créneau disponible.</p>
                                @endforelse
                                </ul>
                                <button class="text-white bg-green-700 hover:bg-green-800 focus:outline-none mt-5 focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="submit">Confirmer</button>

                            </form>
                        </div>
    @endisset

        </div>
    </div>

@endsection
