<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserRequestDTO;
use App\Models\Vet;

class VeterinaireResponseDTO
{
    public function __construct(
        public int            $id,
        public UserRequestDTO $user,
        public string         $numeroLicence,
        public string         $nomClinique,
        public int            $NbAnsExperience,
        public string         $dateDeNaissance,
        public string         $licenceExpiration,
        public string         $horaires,
        public string         $certification,
        public int            $user_id,
    ) {}



    public static function fromModel(Vet $vet): VeterinaireResponseDTO
    {
        return new self(
            $vet->id,
            UserRequestDTO::fromModel($vet->user),
            $vet->numeroLicence,
            $vet->nomClinique,
            $vet->NbAnsExperience,
            $vet->dateDeNaissance,
            $vet->licenceExpiration,
            $vet->horaires,
            $vet->certification,
            $vet->user_id,
        );
    }
}
