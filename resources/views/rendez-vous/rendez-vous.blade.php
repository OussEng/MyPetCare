@extends('layouts.base')

@section('content')
    <h2>Prendre un rendez-vous</h2>


    <form method="GET" action="{{ route('rendez-vous.index', ['id' => $id]) }}">
        <label for="date">Choisissez une date :</label>

        <input type="date" name="date" id="date" value="{{ $selectedDate ?? '' }}">

        <button type="submit">Voir les créneaux</button>
    </form>

    @isset($selectedDate)
        <div>
            <form method="POST" action="{{ route('rendez-vous.store', ['id' => $id]) }}">
                @csrf
                <label for="motif" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motif :</label>
                <label for="espece" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Espece :</label>
                <select id="animal_id" name="animal_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach($animaux as $animal)
                        <option value="{{ $animal->id }}" >{{$animal->nom}}</option>
                    @endforeach
                </select>
                <input type="text" id="motif" name="motif"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Motif de ce rendez-vous" required/>
                @forelse($slots as $slot)
                    <input type="radio" id="slot-{{ $loop->index }}" name="slot" value="{{ $slot }}">
                    <label for="slot-{{ $loop->index }}">{{ \Carbon\Carbon::parse($slot)->format('H:i') }}</label><br>
                @empty
                    <p>Aucun créneau disponible.</p>
                @endforelse

                <button type="submit">select</button>

            </form>
        </div>
    @endisset

@endsection
