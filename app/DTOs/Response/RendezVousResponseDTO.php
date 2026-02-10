<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserDTO;
use App\Models\Etat;
use App\Models\RendezVous;
use DateTimeImmutable;

class RendezVousResponseDTO
{


    public function __construct(
        public int                $id,
        public DateTimeImmutable  $dateHeureDebut,
        public string             $motif,
        public UserDTO            $user,
        public EtatResponseDTO    $etat,
        public VeterinaireViewDTO $veterinaire,
        public AnimalResponseDTO  $animal,
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
        new DateTimeImmutable($rendezVous->dateHeuredebut),
        $rendezVous->motif,
        UserDTO::fromModel($rendezVous->user),
        EtatResponseDTO::fromModel($rendezVous->etat),
        VeterinaireViewDTO::fromModel($rendezVous->veterinaire),
        AnimalResponseDTO::fromModel($rendezVous->animal),
        );

    }
}
