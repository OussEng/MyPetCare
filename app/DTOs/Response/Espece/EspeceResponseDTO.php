<?php

namespace App\DTOs\Response\Espece;

use App\DTOs\Response\Vaccination\VaccinationResponseDTO;
use App\Models\Espece;
use Illuminate\Support\Collection;

class EspeceResponseDTO
{



    public function __construct(
        public int $id,
        public string $libelle,
        public Collection $vaccinations,

    )
    {
    }

    public static function fromModel(Espece $espece): EspeceResponseDTO
    {
        return new self(
        $espece->id,
        $espece->libelle,
        $espece->vaccinations->map(fn ($v) => VaccinationResponseDTO::fromModel($v)));

    }
}
