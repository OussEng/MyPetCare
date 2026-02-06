<?php

namespace App\DTOs\Response;

use App\Models\Vaccination;

class VaccinationResponseDTO
{


    public function __construct(
        public int $id,
        public string $nom_vaccine,
        public string $info,
    )
    {
    }

    public static function fromModel(Vaccination $vac)
    {
        return new self(
            $vac->id,
            $vac->nom_vaccine,
            $vac->info,
        );
    }
}
