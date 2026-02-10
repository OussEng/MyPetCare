<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


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
            'etat_id' => 1 ,
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
            'motif' => 'string|required',
            'veterinaire_id' => 'integer|required',
            'animal_id' => 'integer|required',
            'user_id' => 'integer|required',
            'etat_id' => 'integer|required',
        ];
    }
}
