<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VetProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'prenom'          => ['required', 'string', 'max:255'],
            'nom'             => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(Auth::id())],
            'numero'          => ['required', 'string', 'max:20'],
            'adresse'         => ['required', 'string', 'max:255'],

            'nomClinique'     => ['required', 'string', 'max:255'],
            'adresseClinique' => ['required', 'string', 'max:255'],
            'NbAnsExperience' => ['required', 'integer', 'min:0'],
            'dateDeNaissance' => ['required', 'date'],
            'certification'   => ['required', 'string', 'max:255'],
        ];
    }
}

