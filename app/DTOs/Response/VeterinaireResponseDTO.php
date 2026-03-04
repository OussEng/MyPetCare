<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserRequestDTO;
use App\Models\Vet;
use Illuminate\Support\Collection;

class VeterinaireResponseDTO
{
    public function __construct(
        public int            $id,
        public UserRequestDTO $user,
        public string         $numeroLicence,
        public string         $nomClinique,
        public string         $adresseClinique,
        public int            $NbAnsExperience,
        public string         $dateDeNaissance,
        public string         $licenceExpiration,
        public string         $certification,
        public Collection $langues,
        public int            $user_id,
    ) {}



    public static function fromModel(Vet $vet): VeterinaireResponseDTO
    {
        return new self(
            $vet->id,
            UserRequestDTO::fromModel($vet->user),
            $vet->numeroLicence,
            $vet->nomClinique,
            $vet->adresseClinique,
            $vet->NbAnsExperience,
            $vet->dateDeNaissance,
            $vet->licenceExpiration,
            $vet->certification,
            $vet->langues->map(fn($langue) => LangueResponseDTO::fromModel($langue)),
            $vet->user_id,
        );
    }
}
