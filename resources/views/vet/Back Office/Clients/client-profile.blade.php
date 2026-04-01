@extends('layouts.backoffice')
@section('content')
    <div class="ml-72 p-5">
        <div class="bg-white rounded-2xl p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 mr-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{$client->nom}} {{$client->prenom}}</h1>
                        <p class="text-gray-500">Client ID: {{$client->id}}</p>

                    </div>
                </div>

            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">

            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Contact</h2>
                <div class="space-y-3 text-gray-600">
                    <p><span class="font-medium text-gray-700">Email:</span> {{$client->email}}</p>
                    <p><span class="font-medium text-gray-700">Numero Tél:</span> {{$client->numero}}</p>
                    <p><span class="font-medium text-gray-700">Address:</span> {{$client->adresse}}</p>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-2xl">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 h-">Animaux :</h2>

                <div x-data="{ 'showModal': false }" x-cloak @keydown.escape="showModal = false">
                    <button
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium  text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                        type="button" @click="showModal = true">Ajouter
                    </button>

                    <div
                        class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                        x-transition
                        x-show="showModal"
                    >
                        <div
                            class="px-6 py-4 mx-auto text-left bg-white rounded shadow-lg w-1/3 sm:w-1/2 absolute"
                            @click.away="showModal = false"
                            x-transition:enter="motion-safe:ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                        >

                            <div class="flex items-center justify-between">
                                <h5 class="mr-3 text-black max-w-none mb-3 font-bold">Ajouter un animal :</h5>

                                <button type="button" class="z-50 cursor-pointer" @click="showModal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div>


                                <form method="POST" action="{{route('animaux.save')}}" class="max-w-sm mx-auto">
                                    @csrf
                                    <div class="mb-5">

                                        <label for="nom"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client
                                            :</label>
                                        <input value="{{$client->nom}} {{$client->prenom}}" type="text"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled/>
                                        <input type="hidden" name="user_id" value="{{ $client->id }}">


                                        <label for="nom"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom
                                            :</label>
                                        @error('nom')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <input type="text" id="nom" name="nom"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="Nom..." />


                                        <label for="espece"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Espece
                                            :</label>
                                        @error('espece_id')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <select  id="espece" name="espece_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option class="opacity-30" selected disabled value=""> Sélectionnez l'espece
                                                ...
                                            </option>
                                            @foreach($especes as $espece)
                                                <option value="{{ $espece->id }}">{{$espece->libelle}}</option>
                                            @endforeach
                                        </select>

                                        <label for="sexe"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sexe
                                            :</label>
                                        @error('sexe_id')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <select  id="sexe" name="sexe_id"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option class="opacity-30" value="" selected disabled> Sélectionnez le sexe ...
                                            </option>
                                            @foreach($sexes as $sexe)
                                                <option value="{{ $sexe->id }}">{{$sexe->libelle}}</option>
                                            @endforeach
                                        </select>


                                        <label for="race"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Race
                                            :</label>
                                        <input type="text" id="race" name="race"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="Chat européen..."/>

                                        <label for="dateNaissance"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                                            de naissance :</label>
                                        <input type="date" id="dateNaissance" name="dateNaissance"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder=""/>


                                        <label for="poids"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poids
                                            :</label>
                                        <input type="number" id="poids" name="poids"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="Poids... (en Kg)"/>


                                        <div class="form-group">
                                            <input
                                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none mt-2 focus:ring-4 focus:ring-gray-300 font-medium  text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                                type="submit" value="Ajouter">
                                        </div>

                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div
                x-data="{
                    showDeleteModal: false, selectedAnimalId: null, selectedAnimalName: null,
                    showVaccinationModal: false,
                    showEditModal: false,
                    editAnimal: { id: null, nom: '', espece_id: null, sexe_id: null, race: '', dateNaissance: '', poids: '' }
                }"
                x-cloak @keydown.escape="showDeleteModal = false; showEditModal = false">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($client->animaux as $animal)

                        <div class="border rounded-xl p-5 hover:shadow-md transition bg-gray-50">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-bold text-gray-800">{{$animal->nom}}</h3>


                                @if($animal->vaccinations->isEmpty())
                                    <span
                                        class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Non vacciné</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Vacciné</span>
                                @endif


                            </div>
                            <div class="text-gray-600 text-sm space-y-1">
                                <p><span class="font-medium text-gray-700">Espece:</span> {{$animal->espece->libelle}}
                                </p>
                                @if($animal->race)
                                    <p><span class="font-medium text-gray-700">Race:</span> {{$animal->race}}</p>
                                @else
                                    <p><span class="font-medium text-gray-700">Race:</span> Inconnue</p>
                                @endif


                                @if($animal->age())
                                    <p><span class="font-medium text-gray-700">Age:</span> {{$animal->age()}}</p>
                                @else
                                    <p><span class="font-medium text-gray-700">Age:</span> Inconnue </p>
                                @endif


                                <p><span class="font-medium text-gray-700">Sexe:</span>{{$animal->sexe->libelle}}</p>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="{{route('vaccinations', $animal->id)}}"
                                   class="text-sm text-teal-600 hover:underline">Vaccination</a>
                                <div class="flex gap-3">
                                    <button class="text-sm text-blue-500 hover:text-blue-700"
                                            @click="editAnimal = {
                                                id: {{ $animal->id }},
                                                nom: '{{ addslashes($animal->nom) }}',
                                                espece_id: {{ $animal->espece->id }},
                                                sexe_id: {{ $animal->sexe->id }},
                                                race: '{{ addslashes($animal->race ?? '') }}',
                                                dateNaissance: '{{ $animal->dateNaissance ?? '' }}',
                                                poids: '{{ $animal->poids ?? '' }}'
                                            }; showEditModal = true">
                                        Modifier
                                    </button>
                                    <button class="text-sm text-gray-500 hover:text-red-500"
                                            @click="selectedAnimalId = {{$animal->id}}; selectedAnimalName = '{{$animal->nom}}' ; showDeleteModal = true">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                            <p class="font-bold">Pas d'animal</p>
                            <p class="text-sm">Ce client n'a pas d'animaux</p>
                        </div>
                    @endforelse


                </div>


                <div
                    x-show="showDeleteModal"
                    x-transition
                    class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
                >
                    <div
                        @click.away="showDeleteModal = false"
                        class="bg-white rounded-lg p-6 w-1/3"
                    >
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold">Suppression:</h3>
                            <button @click="showDeleteModal = false">&times;</button>
                        </div>

                        <div x-text="'Voulez-vous Supprimer ' + selectedAnimalName + ' ?'" class="mb-10"></div>

                        <div class=""></div>
                        <form method="POST"
                              :action="`{{ route('animaux.delete', ':id') }}`.replace(':id', selectedAnimalId)"
                              class="inline-block mr-5">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-white bg-gray-800  focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium  text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 hover:bg-red-700 ">
                                Oui
                            </button>
                        </form>
                        <button @click="showDeleteModal = false"
                                class="text-gray-800 bg-white hover:text-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium  text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                            Non
                        </button>


                    </div>
                </div>

                {{-- ── Modal Modifier ───────────────────────────────────────── --}}
                <div
                    x-show="showEditModal"
                    x-transition
                    class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md"
                >
                    <div
                        @click.away="showEditModal = false"
                        class="bg-white rounded-lg p-6 w-1/3 sm:w-1/2 max-h-[90vh] overflow-y-auto"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-black">Modifier l'animal :</h3>
                            <button type="button" @click="showEditModal = false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form method="POST"
                              :action="`{{ route('animaux.update', ':id') }}`.replace(':id', editAnimal.id)">
                            @csrf
                            @method('PUT')

                            <div class="space-y-3">
                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Nom :</label>
                                    <input type="text" name="nom" x-model="editAnimal.nom"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                           placeholder="Nom..."/>
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Espèce :</label>
                                    <select name="espece_id" x-model="editAnimal.espece_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" disabled>Sélectionnez l'espèce...</option>
                                        @foreach($especes as $espece)
                                            <option value="{{ $espece->id }}">{{ $espece->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Sexe :</label>
                                    <select name="sexe_id" x-model="editAnimal.sexe_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="" disabled>Sélectionnez le sexe...</option>
                                        @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id }}">{{ $sexe->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Race :</label>
                                    <input type="text" name="race" x-model="editAnimal.race"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                           placeholder="Chat européen..."/>
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Date de naissance :</label>
                                    <input type="date" name="dateNaissance" x-model="editAnimal.dateNaissance"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Poids :</label>
                                    <input type="number" name="poids" x-model="editAnimal.poids"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                           placeholder="Poids... (en Kg)"/>
                                </div>

                                <div class="flex gap-3 pt-2">
                                    <button type="submit"
                                            class="text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5">
                                        Enregistrer
                                    </button>
                                    <button type="button" @click="showEditModal = false"
                                            class="text-gray-800 bg-white border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium text-sm px-5 py-2.5">
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

@endsection
