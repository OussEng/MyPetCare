<?php

namespace App\DTOs;

class VeterinarianViewDTO
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
}
