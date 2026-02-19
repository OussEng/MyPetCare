<?php

namespace App\DTOs\Response;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Support\Collection;

class UserResponseDTO
{

    public function __construct(
        public string $id,
        public string $prenom,
        public string $nom,
        public string $email,
        public string $numero,
        public string $adresse,
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
            $user->animals->map(fn ($animal) => AnimalResponseDTO::fromModel($animal)),
            $user->rendervous->map(fn ($rendezVous) => RendezVousResponseDTO::fromModel($rendezVous))
        );
    }

}
