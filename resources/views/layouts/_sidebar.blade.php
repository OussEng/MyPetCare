<aside class="flex flex-col fixed top-0 left-0 z-40 w-64 h-full shadow-[5px_0px_5px_-2px_rgba(0,_0,_0,_0.3)] transition-transform -translate-x-full sm:translate-x-0">
    <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
        <a href="{{route('home')}}" class="flex items-center ps-2.5 mb-5">
            <img src="{{asset('imgs/logo.png')}}" class="h-8 me-3" alt="cat Logo" />
            <span class="self-center text-lg ml-4 text-heading font-semibold whitespace-nowrap">My little Pet</span>
        </a>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{route('veterinaire.backoffice')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48" >
                        <path d="M 23.951172 4 A 1.50015 1.50015 0 0 0 23.072266 4.3222656 L 8.859375 15.519531 C 7.0554772 16.941163 6 19.113506 6 21.410156 L 6 40.5 C 6 41.863594 7.1364058 43 8.5 43 L 18.5 43 C 19.863594 43 21 41.863594 21 40.5 L 21 30.5 C 21 30.204955 21.204955 30 21.5 30 L 26.5 30 C 26.795045 30 27 30.204955 27 30.5 L 27 40.5 C 27 41.863594 28.136406 43 29.5 43 L 39.5 43 C 40.863594 43 42 41.863594 42 40.5 L 42 21.410156 C 42 19.113506 40.944523 16.941163 39.140625 15.519531 L 24.927734 4.3222656 A 1.50015 1.50015 0 0 0 23.951172 4 z M 24 7.4101562 L 37.285156 17.876953 C 38.369258 18.731322 39 20.030807 39 21.410156 L 39 40 L 30 40 L 30 30.5 C 30 28.585045 28.414955 27 26.5 27 L 21.5 27 C 19.585045 27 18 28.585045 18 30.5 L 18 40 L 9 40 L 9 21.410156 C 9 20.030807 9.6307412 18.731322 10.714844 17.876953 L 24 7.4101562 z" stroke="black" stroke-width="1"></path>
                    </svg>                    <span class="flex-1 ms-3 whitespace-nowrap">Acceuil</span>
                </a>
            </li>
            <li>
                <a href="{{route('vet.rendez-vous.list')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Mes Rendez Vous</span>
                </a>
            </li>
            <li>
                <a href="{{route('veterinaire.clients')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Clients</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Déconnexion</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

    </div>



    <div class="relative pl-2">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-4/5 border-t border-gray-300 "></div>

        <div class="flex justify-between align-end self-end w-full h-12 border-r mt-1 mb-1">
            <img src="{{asset('imgs/pfp.png')}}" alt="pfp" class="w-10 h-10 rounded-full mt-1">
            <span class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group space-y-2 font-medium">{{Auth::user()->vet->user->nom}} {{Auth::user()->vet->user->prenom}}</span>

            <div class="self-center">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>



    </div>
</aside>
