<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->input('user_id') ?? $this->user()->id,
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
            'nom' => 'required|string',
            'espece_id' => 'required|integer',
            'race' => 'nullable|string',
            'dateNaissance' => 'nullable|date',
            'poids' => 'nullable|string',
            'sexe_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
}
