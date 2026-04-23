<?php

namespace App\DTOs\Response\User;

use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\DTOs\Response\RendezVous\RendezVousResponseDTO;
use App\Models\User;
use Illuminate\Support\Collection;

class UserResponseDTO
{

    public function __construct(
        public int        $id,
        public string     $prenom,
        public string     $nom,
        public string     $email,
        public string     $numero,
        public string     $adresse,
        public ?string    $deleted_at,
        public Collection $animaux,
        public Collection $rendezVous,
    )
    {}

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->prenom,
            $user->nom,
            $user->email,
            $user->numero,
            $user->adresse,
            $user->deleted_at,
            $user->animals->map(fn ($animal) => AnimalResponseDTO::fromModel($animal)),
            $user->rendezvous->map(fn ($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous))
        );
    }

}
