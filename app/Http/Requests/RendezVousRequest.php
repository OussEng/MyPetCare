<?php

namespace App\Http\Requests;

use App\Enums\Etat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class RendezVousRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    protected function prepareForValidation()
    {
        $this->merge([
            'etat' => Etat::CONFIRMER->value,
            'veterinaire_id' => $this->route('id'),
            'user_id' => $this->user()->id,
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dateHeureDebut' => 'date|required',
            'motif' => 'required',
            'veterinaire_id' => 'integer|required',
            'animal_id' => 'integer|required',
            'user_id' => 'integer|required',
            'etat' => ['required', new Enum(Etat::class)],
        ];
    }
    public function messages(): array
    {
        return [
            'dateHeureDebut.required' => 'Veuillez sélectionner une date et une heure.',
            'dateHeureDebut.date' => 'La date et l\'heure doivent être valides.',
            'motif.required' => 'Veuillez indiquer le motif du rendez-vous.',
            'animal_id.required' => 'Veuillez sélectionner un animal.',
            'etat.required' => 'L\'état du rendez-vous est requis.',
        ];
    }

}
