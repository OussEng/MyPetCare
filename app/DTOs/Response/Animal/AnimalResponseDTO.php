<?php

namespace App\DTOs\Response\Animal;

use App\DTOs\Response\Espece\EspeceResponseDTO;
use App\DTOs\Response\Sexe\SexeResponseDTO;
use App\DTOs\Response\User\UserSimpleDTO;
use App\DTOs\Response\Vaccination\VaccinationResponseDTO;
use App\Models\Animal;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnimalResponseDTO
{
    public function __construct(
        public int               $id,
        public string            $nom,
        public ?string           $race = null,
        public EspeceResponseDTO $espece,
        public ?string           $dateNaissance = null,
        public ?string           $poids = null,
        public SexeResponseDTO   $sexe,
        public UserSimpleDTO    $user,
        public Collection        $vaccinations,
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
            UserSimpleDTO::fromModel($animal->user),
            $animal->vaccinations->map(
                fn ($v) => VaccinationResponseDTO::fromModel($v)
            )
        );
    }

    public function age(): ?int
    {
        return $this->dateNaissance
            ? Carbon::parse($this->dateNaissance)->age
            : null;
    }
}
