<?php

namespace App\DTOs\Requests\Veterinaire;

use Illuminate\Http\Request;

class VeterinaireCreateDTO
{
    public function __construct(
        public string $numeroLicence,
        public string $nomClinique,
        public string $adresseClinique,
        public int $NbAnsExperience,
        public string $dateDeNaissance,
        public string $licenceExpiration,
        public ?string $certification,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            numeroLicence: $data['numeroLicence'],
            nomClinique: $data['nomClinique'],
            adresseClinique: $data['adresseClinique'],
            NbAnsExperience: $data['NbAnsExperience'],
            dateDeNaissance: $data['dateDeNaissance'],
            licenceExpiration: $data['licenceExpiration'],
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
            'certification' => $this->certification,
            'adresseClinique' => $this->adresseClinique,
        ];
    }
}
