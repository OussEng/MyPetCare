<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserRequestDTO;
use App\Enums\Etat;
use App\Models\RendezVous;
use DateTimeImmutable;

class RendezVousResponseDTO
{


    public function __construct(
        public int                $id,
        public DateTimeImmutable  $dateHeureDebut,
        public string             $motif,
        public UserRequestDTO     $user,
        public VeterinaireViewDTO $veterinaire,
        public AnimalResponseDTO  $animal,
        public Etat $etat,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public static function fromModel(RendezVous $rendezVous): self
    {
        return new self(
        $rendezVous->id,
        new DateTimeImmutable($rendezVous->dateHeureDebut),
        $rendezVous->motif,
        UserRequestDTO::fromModel($rendezVous->user),
        VeterinaireViewDTO::fromModel($rendezVous->veterinaire),
        AnimalResponseDTO::fromModel($rendezVous->animal),
        $rendezVous->etat,
        );

    }
}
