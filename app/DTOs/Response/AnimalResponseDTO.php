<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserDTO;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AnimalResponseDTO
{
    public function __construct(
        public int $id,
        public string  $nom,
        public ?string $race = null,
        public EspeceResponseDTO $espece,
        public ?string $dateNaissance = null,
        public ?string $poids = null,
        public SexeResponseDTO $sexe,
        public UserDTO $user,
        public Collection $vaccinations,
    ) {}

    public static function fromModel(Animal $animal): self
    {
        return new self(
            $animal->id,
            $animal->nom,
            $animal->race,
            EspeceResponseDTO::fromModel($animal->espece),
            $animal->dateNaissance,
            $animal->poids,
            SexeResponseDTO::fromModel($animal->sexe),
            UserDTO::fromModel($animal->user),
            $animal->vaccinations->map(
                fn ($v) => VaccinationResponseDTO::fromModel($v)
            )
        );
    }
}
