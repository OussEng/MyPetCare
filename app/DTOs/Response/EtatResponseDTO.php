<?php

namespace App\DTOs\Response;

use App\Models\Etat;

class EtatResponseDTO
{


    public function __construct(
        public int $id,
        public string $libelle,
    )
    {
    }

    public static function fromModel(Etat $etat) : self
    {

        return new self(
           $etat->id,
           $etat->libelle,
        );

    }
}
