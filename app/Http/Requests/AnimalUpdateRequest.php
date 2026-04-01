<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'           => 'required|string|max:50',
            'espece_id'     => 'required|integer',
            'sexe_id'       => 'required|integer',
            'race'          => 'nullable|string',
            'dateNaissance' => 'nullable|date',
            'poids'         => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'       => "Le nom de l'animal est requis.",
            'nom.max'            => 'Le nom ne doit pas dépasser 50 caractères.',
            'espece_id.required' => "L'espèce est requise.",
            'espece_id.integer'  => "L'espèce doit être un nombre entier.",
            'sexe_id.required'   => 'Le sexe est requis.',
        ];
    }
}

