@extends('layouts.base')

@section('content')

    <div class="flex justify-center mb-96 mt-20">

        <div class="w-11/12 lg:w-2/3">
            <h1 class="text-center mb-10 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Ajouter un Animal</h1>

            <form method="POST" action="{{route('animaux.save')}}" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom :</label>
                @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <input type="text" id="nom" name="nom"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Nom de votre animal..." />


                <label for="espece" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Espece :</label>
                @error('espece_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <select  id="espece" name="espece_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" class="opacity-30" selected disabled  > Sélectionnez l'espece de votre animal... </option>
                        @foreach($especes as $espece)
                        <option value="{{ $espece->id }}" >{{$espece->libelle}}</option>
                        @endforeach
                </select>

                <label for="sexe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sexe :</label>
                @error('sexe_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <select  id="sexe" name="sexe_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option class="opacity-30" value="" selected disabled  > Sélectionnez le sexe de votre animal... </option>
                    @foreach($sexes as $sexe)
                        <option value="{{ $sexe->id }}" >{{$sexe->libelle}}</option>
                    @endforeach
                </select>



                <label for="race" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Race :</label>
                <input type="text" id="race" name="race"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Chat européen..."/>

                <label for="dateNaissance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de naissance :</label>
                <input type="date" id="dateNaissance" name="dateNaissance"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder=""/>


                <label for="poids" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poids :</label>
                <input type="number" id="poids" name="poids"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Poids... (en Kg)"/>


                <div class="form-group">
                    <input  class=" mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2" type="submit" value="Ajouter">
                    <a href="{{ route('animaux') }}"
                       class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Annuler
                    </a>
                </div>

            </div>

        </form>
    </div>
    </div>

@endsection
