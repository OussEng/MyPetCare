<?php

namespace App\DTOs\Response;

use App\DTOs\Requests\UserRequestDTO;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Models\Vaccination;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        public UserRequestDTO    $user,
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
            UserRequestDTO::fromModel($animal->user),
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
