<nav class="bg-gray-800 relative z-50">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                <button type="button"
                        command="--toggle" commandfor="mobile-menu"
                        class="z-50 relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>

                    <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>


                    <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>


            </div>
            <div class="absolute inset-x-0 flex justify-center sm:static sm:flex-none">
                <a href="{{route('home')}}" class=""
                   aria-current="page"><img class="h-14 " src="{{asset('imgs/logo.png')}}" width="55px" alt="logo"></a>
            </div>

            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">

                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">



                        @if(Route::is('home'))
                            <a href="{{route('home')}}"
                               class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Accueil</a>
                        @else
                            <a href="{{route('home')}}"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Accueil</a>
                        @endif


                        @if(Auth::check())
                            @if(Route::is('list.vets'))
                                    <a href="{{route('list.vets')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Rendez
                                        vous</a>
                            @else
                                    <a href="{{route('list.vets')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Rendez
                                        vous</a>
                            @endif


                            @if(Route::is('animaux'))
                                    <a href="{{route('animaux')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Mes
                                        animaux</a>
                            @else
                                    <a href="{{route('animaux')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mes
                                        animaux</a>
                            @endif

                            @if(Route::is('profile.edit'))
                                    <a href="{{route('profile.edit')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Profile</a>
                            @else
                                    <a href="{{route('profile.edit')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Profile</a>
                            @endif

                            @if(Route::is('rendez-vous.list'))
                                    <a href="{{route('rendez-vous.list')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Mes
                                        Rendez vous</a>
                            @else
                                    <a href="{{route('rendez-vous.list')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mes
                                        Rendez vous</a>
                            @endif

                            @if(auth()->user()->isVet())
                                    <a href="{{route('veterinaire.backoffice')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mon espace Vétérinaire</a>

                            @endif

                                @if(auth()->user()->isAdmin())
                                    <a href="{{route('admin.backoffice')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mon espace Admin</a>

                                @endif

                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Déconnexion</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        @else
                            @if(Route::is('register') || Route::is('register_vet.form') || Route::is('register.options'))
                                    <a href="{{route('register.options')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Inscription</a>
                            @else
                                    <a href="{{route('register.options')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Inscription</a>
                            @endif

                            @if(Route::is('login'))
                                    <a href="{{route('login')}}"
                                       class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Connexion</a>
                            @else
                                    <a href="{{route('login')}}"
                                       class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Connexion</a>
                            @endif

                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden sm:hidden " id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 ">
            <a href="{{route('home')}}"
               class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>


            @if(Auth::check())
                <a href="{{route('list.vets')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Rendez
                    vous</a>
                <a href="{{route('animaux')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mes
                    animaux</a>
                <a href="{{route('profile.edit')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Profile</a>

                <a href="{{route('rendez-vous.list')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Mes
                    Rendez vous</a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            @else
                <a href="{{route('register')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Inscription</a>
                <a href="{{route('register_vet.form')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Inscription
                    Vet</a>
                <a href="{{route('login')}}"
                   class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Connexion</a>
            @endif


        </div>
    </div>
</nav>
