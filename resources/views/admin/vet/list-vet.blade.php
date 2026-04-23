@extends('layouts.backoffice')
@section('content')

<div class="py-12 ml-64" >
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
<h1 class="text-3xl font-bold mb-6 text-gray-800">Vétérinaires en attente de vérification</h1>
                @if($vets->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Aucun vétérinaire trouvé.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clinique</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Expérience</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Licence</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($vets as $vet)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $vet->user->nom }} {{ $vet->user->prenom }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $vet->user->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $vet->nomClinique }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $vet->NbAnsExperience }} ans
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $vet->numeroLicence }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('admin.vet.detail', $vet->id) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Détail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-10 ml-24">
    {{ $vets->withQueryString()->links('pagination.custom') }}
</div>

@endsection
