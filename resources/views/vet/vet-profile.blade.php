@extends('layouts.base')
@section('content')

    <div class="relative w-full min-h-screen bg-cover bg-center"
         style="background-image: url('{{ asset('imgs/cat.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 flex justify-center pt-20 pb-32 px-4">
            <div class="w-full lg:w-2/3">
                <h2 class="text-4xl font-extrabold text-white text-center mb-40 xl:mb-5">
                    {{$vet->user->nom}} {{$vet->user->prenom}} :
                </h2>
                <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto">


                    <div class="w-full lg:w-2/5">
                        <img src="{{asset('imgs/pfp.png')}}"
                             class="rounded-none lg:rounded-lg shadow-2xl hidden lg:block h-96" alt="">
                    </div>

                    <div id="profile"
                         class="w-full lg:w-3/5 rounded lg:rounded shadow-2xl bg-white mx-6 lg:mx-0">

                        <div class="p-4 md:p-12 text-center lg:text-left">

                            <img src="{{asset('imgs/pfp.png')}}"
                                 class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center"
                                 alt="">

                            <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{$vet->user->nom}} {{$vet->user->prenom}}</h1>
                            <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-green-500 opacity-25"></div>

                            <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">
                                <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z"/>
                                </svg> {{$vet->nomClinique}}
                            </p>

                            <p class="pt-2 text-gray-600 text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                                <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82z"/>
                                </svg> {{$vet->adresseClinique}}
                            </p>

                            <p class="pt-2 text-gray-600 text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                                <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82z"/>
                                </svg> {{$vet->NbAnsExperience}} Ans d'experience
                            </p>


                            <h5 class="text-xl font-bold dark:text-white">Contact</h5>
                            <div class="flex flex-col md:flex-row lg:flex-col gap-4 ml-10 xl:ml-0">
                                <div class="border-green-700 border-2 w-52 rounded p-2">
                                    <ul>
                                        <li>Tel : {{$vet->user->numero}}</li>
                                        <li>Email : {{$vet->user->email}}</li>
                                    </ul>
                                </div>

                            </div>

                            @if(!$vet->langues->isEmpty())
                            <h5 class=" text-xl font-bold dark:text-white">Langues</h5>
                            <div class="border-green-700 border-2 p-2 w-52 rounded ml-10 xl:ml-0">
                                <ul>
                                    @foreach($vet->langues as $langue)
                                        <li>{{$langue->libelle}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="pt-12 pb-8 ">
                                <a href="{{route('rendez-vous.index' , $vet->id)}}"
                                   class="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full">
                                    Rendez-vous
                                </a>
                            </div>


                        </div>


                    </div>

                </div>
            </div>


        </div>
    </div>


@endsection
