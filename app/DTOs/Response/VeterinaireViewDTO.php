<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserDTO;
use App\Models\Vet;

class VeterinaireViewDTO
{
    public function __construct(
        public int $id,
        public UserDTO $user,
        public string $numeroLicence,
        public string $nomClinique,
        public int $NbAnsExperience,
        public string $dateDeNaissance,
        public string $licenceExpiration,
        public string $horaires,
        public string $certification,
        public int $user_id,
        public string $created_at,
        public string $updated_at
    ) {}



    public static function fromModel(Vet $vet): VeterinaireViewDTO
    {
        return new self(
            $vet->id,
            UserDTO::fromModel($vet->user),
            $vet->numeroLicence,
            $vet->nomClinique,
            $vet->NbAnsExperience,
            $vet->dateDeNaissance,
            $vet->licenceExpiration,
            $vet->horaires,
            $vet->certification,
            $vet->user_id,
            $vet->created_at,
            $vet->updated_at
        );
    }
}
