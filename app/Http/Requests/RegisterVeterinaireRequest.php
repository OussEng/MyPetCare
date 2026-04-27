<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterVeterinaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string'],
            'prenom' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'numero' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string'],
            'dateDeNaissance' => 'required|date|date_format:Y-m-d',
            'adresseClinique' => 'required|string',
            'numeroLicence' => 'required|string|max:50',
            'nomClinique' => 'required|string|max:255',
            'NbAnsExperience' => 'required|integer|min:0',
            'licenceExpiration' => 'required|date|date_format:Y-m-d',
            'certification' => 'required|string|max:255',
        ];
    }
}
