<?php

namespace App\DTOs\Response\Langue;

use App\Models\Langue;

class LangueResponseDTO
{
    public function __construct(
        public int $id,
        public string $libelle,
    ){}

    public static function fromModel(Langue $langue): LangueResponseDTO
    {
        return new self(
            $langue->id,
            $langue->libelle,
        );

    }

}
