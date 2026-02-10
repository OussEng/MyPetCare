<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeterinaireRequest extends FormRequest
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
            'dateDeNaissance' => 'required|date|date_format:Y-m-d',
            'horaires' => 'nullable|string',
            'numeroLicence' => 'required|string|max:50',
            'nomClinique' => 'required|string|max:255',
            'NbAnsExperience' => 'required|integer|min:0',
            'licenceExpiration' => 'required|date|date_format:Y-m-d',
            'certification' => 'required|string|max:255',

        ];
    }
}
