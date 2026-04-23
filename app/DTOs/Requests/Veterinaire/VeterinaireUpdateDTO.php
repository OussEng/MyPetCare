<?php

namespace App\DTOs\Requests\Veterinaire;

use Illuminate\Foundation\Http\FormRequest;

class VeterinaireUpdateDTO
{
    public function __construct(
        public readonly string $nomClinique,
        public readonly string $adresseClinique,
        public readonly int    $NbAnsExperience,
        public readonly string $dateDeNaissance,
        public readonly string $certification,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            nomClinique:     $request->validated('nomClinique'),
            adresseClinique: $request->validated('adresseClinique'),
            NbAnsExperience: (int) $request->validated('NbAnsExperience'),
            dateDeNaissance: $request->validated('dateDeNaissance'),
            certification:   $request->validated('certification'),
        );
    }

    public function toArray(): array
    {
        return [
            'nomClinique'     => $this->nomClinique,
            'adresseClinique' => $this->adresseClinique,
            'NbAnsExperience' => $this->NbAnsExperience,
            'dateDeNaissance' => $this->dateDeNaissance,
            'certification'   => $this->certification,
        ];
    }
}

