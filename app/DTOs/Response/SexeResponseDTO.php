<?php

namespace App\DTOs\Response;

use App\Models\Sexe;

class SexeResponseDTO
{


    public function __construct(
        public int $id,
        public string $libelle,
    )
    {}

    public static function fromModel(Sexe $sexe)
    {
        return new self(
            $sexe->id,
            $sexe->libelle,
        );
    }
}
