<?php

namespace App\DTOs\Requests;

use Illuminate\Http\Request;

class VeterinaireCreateDTO
{
    public function __construct(
        public string $numeroLicence,
        public string $nomClinique,
        public int $NbAnsExperience,
        public string $dateDeNaissance,
        public string $licenceExpiration,
        public ?string $horaires = null,
        public ?string $certification,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            numeroLicence: $data['numeroLicence'],
            nomClinique: $data['nomClinique'],
            NbAnsExperience: $data['NbAnsExperience'],
            dateDeNaissance: $data['dateDeNaissance'],
            licenceExpiration: $data['licenceExpiration'],
            horaires: $data['horaires'] ?? null,
            certification: $data['certification'],
        );
    }

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'numeroLicence' => $this->numeroLicence,
            'nomClinique' => $this->nomClinique,
            'NbAnsExperience' => $this->NbAnsExperience,
            'dateDeNaissance' => $this->dateDeNaissance,
            'licenceExpiration' => $this->licenceExpiration,
            'horaires' => $this->horaires,
            'certification' => $this->certification,
        ];
    }
}
