@extends('layouts.backoffice')
@section('content')

    <div class="ml-72 mt-10">
        <h1 class="mt-10 mb-10 text-4xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Mes <span
                class="underline underline-offset-3 decoration-8 decoration-blue-400 dark:decoration-blue-600 ">Rendez vous</span>
        </h1>

        <div class="flex justify-between space-x-2 mb-10" >
            <a href="{{ route('vet.rendez-vous.list') }}"
               class="flex-1 text-center text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                Tous
            </a>

            <a href="{{ route('vet.rendez-vous.list', ['etat' => 'en attente']) }}"
               class="flex-1 text-center text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                En attente
            </a>

            <a href="{{ route('vet.rendez-vous.list', ['etat' => 'confirmé']) }}"
               class="flex-1 text-center text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                Confirmés
            </a>

            <a href="{{ route('vet.rendez-vous.list', ['etat' => 'terminé']) }}"
               class="flex-1 text-center text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                Terminés
            </a>

            <a href="{{ route('vet.rendez-vous.list', ['etat' => 'annulé']) }}"
               class="flex-1 text-center text-sm text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                Annulés
            </a>
        </div>

        <div class="flex justify-center">

        <div class="w-1/5">
            <a href="{{ route('vet.rendez-vous.list', ['jour' => "aujourd'hui"]) }}"
               class="flex-1 text-center text-sm text-white bg-green-600 hover:bg-green-700 active:scale-95 transition-all h-10 rounded-md flex items-center justify-center">
                Aujourd'hui
            </a>
        </div>
    </div>

        <div class="space-y-6">
            <div x-data="{show : false, selectedItem: {} }">
                @foreach($rendezVous as $rv)

                    <div class="bg-white shadow-md rounded-xl border border-gray-200 p-6 hover:shadow-lg transition">

                        <div class="flex justify-around items-center">


                            <div class=" flex items-center md:mr-5 w-32 h-20 text-center tracking-tight text-heading">

                                @if($rv->etat->isPending())
                                    <div class="w-auto p-2 border rounded-full bg-yellow-200 align-middle">{{$rv->etat}}</div>
                                @elseif($rv->etat->isConfirmed())
                                    <div class="w-auto p-2 border rounded-full bg-green-200 align-middle">{{$rv->etat}}</div>

                                @elseif($rv->etat->isFinished())
                                    <div class="w-auto p-2 border rounded-full bg-blue-200 align-middle">{{$rv->etat}}</div>

                                @elseif($rv->etat->isCancelled())
                                    <div class="w-auto p-2 border rounded-full bg-red-200 align-middle">{{$rv->etat}}</div>

                                @endif


                            </div>


                            <div class="border rounded-lg w-44 h-auto p-4 md:mr-4">
                                <div class="flex items-center">
                                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.75 2.5C7.75 2.08579 7.41421 1.75 7 1.75C6.58579 1.75 6.25 2.08579 6.25 2.5V4.07926C4.81067 4.19451 3.86577 4.47737 3.17157 5.17157C2.47737 5.86577 2.19451 6.81067 2.07926 8.25H21.9207C21.8055 6.81067 21.5226 5.86577 20.8284 5.17157C20.1342 4.47737 19.1893 4.19451 17.75 4.07926V2.5C17.75 2.08579 17.4142 1.75 17 1.75C16.5858 1.75 16.25 2.08579 16.25 2.5V4.0129C15.5847 4 14.839 4 14 4H10C9.16097 4 8.41527 4 7.75 4.0129V2.5Z"
                                            fill="#1C274C"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M2 12C2 11.161 2 10.4153 2.0129 9.75H21.9871C22 10.4153 22 11.161 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12ZM17 14C17.5523 14 18 13.5523 18 13C18 12.4477 17.5523 12 17 12C16.4477 12 16 12.4477 16 13C16 13.5523 16.4477 14 17 14ZM17 18C17.5523 18 18 17.5523 18 17C18 16.4477 17.5523 16 17 16C16.4477 16 16 16.4477 16 17C16 17.5523 16.4477 18 17 18ZM13 13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13C11 12.4477 11.4477 12 12 12C12.5523 12 13 12.4477 13 13ZM13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17ZM7 14C7.55228 14 8 13.5523 8 13C8 12.4477 7.55228 12 7 12C6.44772 12 6 12.4477 6 13C6 13.5523 6.44772 14 7 14ZM7 18C7.55228 18 8 17.5523 8 17C8 16.4477 7.55228 16 7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18Z"
                                              fill="#1C274C"/>
                                    </svg>
                                    <div
                                        class="ml-2 tracking-tight text-heading">{{$rv->dateHeureDebut->format('d-m-Y')}}</div>
                                </div>

                                <div class="flex items-center">
                                    <svg fill="#1C274C" width="38px" height="38px" viewBox="0 0 24 24" id="Layer_1"
                                         data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12,2A10,10,0,1,0,22,12,10.01146,10.01146,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Zm1-8.251V7a1,1,0,0,0-2,0v5a1.00586,1.00586,0,0,0,.11816.47217l1.5,2.79883a1.00029,1.00029,0,0,0,1.76368-.94434Z"/>
                                    </svg>
                                    <div class="ml-2 tracking-tight text-heading">{{$rv->dateHeureDebut->format('H')}}
                                        :00
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <img class="w-14 h-14 rounded-full text-3xl font-bold" alt=""
                                     src="{{asset('imgs/user-pfp.png')}}">

                                <span
                                    class="tracking-tight text-heading">{{$rv->user->nom}} {{$rv->user->prenom}}</span>
                            </div>

                            <div>

                                <button
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium  text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"

                                    @click="selectedItem = @js(['id' => $rv->id,'user' => $rv->user,'motif' => $rv->motif,'dateHeureDebut' => $rv->dateHeureDebut->format('d-m-Y H:i'),'etat' => $rv->etat,'animal' => $rv->animal]); show = true">Details
                                </button>
                            </div>

                        </div>


                    </div>

                @endforeach

                    <div x-show="show"
                         x-transition
                         x-cloak
                         class="fixed inset-0 z-30 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md">

                        <div @click.away="show = false" class="bg-white rounded-lg p-6 w-1/3 max-w-xl">

                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold flex items-center">
                                    Rendez-vous Details
                                </h3>
                                <button @click="show = false" class="text-xl font-bold">&times;</button>
                            </div>

                            <div class="space-y-4 text-sm text-gray-700">


                                <div class="border-b pb-2">
                                    <p><strong>Motif:</strong> <span x-text="selectedItem.motif"></span></p>
                                    <p><strong>Date & Heure:</strong> <span x-text="selectedItem.dateHeureDebut"></span></p>
                                </div>


                                <div class="border-b pb-2">
                                    <p><strong>Utilisateur:</strong> <span x-text="selectedItem.user.nom + ' ' + selectedItem.user.prenom"></span></p>
                                    <p><strong>Email:</strong> <span x-text="selectedItem.user.email"></span></p>
                                    <p><strong>Téléphone:</strong> <span x-text="selectedItem.user.numero"></span></p>
                                    <p><strong>Adresse:</strong> <span x-text="selectedItem.user.adresse"></span></p>
                                </div>


                                <div>
                                    <p><strong>Animal:</strong> <span x-text="selectedItem.animal.nom"></span> (<span x-text="selectedItem.animal.espece.libelle"></span>)</p>
                                    <p><strong>Sexe:</strong> <span x-text="selectedItem.animal.sexe.libelle"></span></p>
                                    <p><strong>Poids:</strong> <span x-text="selectedItem.animal.poids ?? 'N/A'"></span></p>
                                    <p><strong>Vaccinations:</strong></p>
                                    <ul class="list-disc list-inside ml-4">
                                        <template x-for="vaccine in selectedItem.animal.vaccinations" :key="vaccine.id">
                                            <li>
                                                <span x-text="vaccine.nom_vaccine"></span> – <span x-text="vaccine.info"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                            </div>

                        </div>

                    </div>

            </div>


        </div>
    </div>

    <div class="mt-10 ml-24">
        {{ $rendezVous->withQueryString()->links('pagination.custom') }}
    </div>
@endsection
