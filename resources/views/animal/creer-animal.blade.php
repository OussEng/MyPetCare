@extends('layouts.base')

@section('content')

    <div class="flex justify-center mb-52">
        <div class="w-1/2 mt-20">
        <form method="POST" action="{{route('animaux.save')}}" class="max-w-sm mx-auto">
            @csrf
            <div class="mb-5">
                <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom :</label>
                <input type="text" id="nom" name="nom"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Nom de votre animal..." required/>


                <label for="espece" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Espece :</label>
                <select id="espece" name="espece_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option class="opacity-30" selected disabled  > Sélectionnez l'espece de votre animal... </option>
                        @foreach($especes as $espece)
                        <option value="{{ $espece->id }}" >{{$espece->libelle}}</option>
                        @endforeach
                </select>

                <label for="sexe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sexe :</label>
                <select id="sexe" name="sexe_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option class="opacity-30" selected disabled  > Sélectionnez le sexe de votre animal... </option>
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
                <input type="text" id="poids" name="poids"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Poids... (en Kg)"/>


                <div class="form-group">
                    <input  class=" mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2" type="submit" value="Ajouter">
                </div>

            </div>

        </form>
    </div>
    </div>

@endsection
