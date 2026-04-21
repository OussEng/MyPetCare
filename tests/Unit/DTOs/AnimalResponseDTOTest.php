<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Requests\UserRequestDTO;
use App\DTOs\Response\AnimalResponseDTO;
use App\DTOs\Response\EspeceResponseDTO;
use App\DTOs\Response\SexeResponseDTO;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class AnimalResponseDTOTest extends TestCase
{
    private function makeFullAnimal(array $override = []): Animal
    {
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());

        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);
        $user = User::factory()->make(['id' => 1, 'prenom' => 'Jean', 'nom' => 'Dupont',
            'email' => 'jean@test.com', 'numero' => '0600', 'adresse' => '1 rue']);

        $animal = Animal::factory()->make(array_merge([
            'id'            => 1,
            'nom'           => 'Rex',
            'race'          => 'Labrador',
            'dateNaissance' => '2020-06-01',
            'poids'         => '10.5',
            'sexe_id'       => 1,
            'espece_id'     => 1,
            'user_id'       => 1,
        ], $override));

        $animal->setRelation('espece', $espece);
        $animal->setRelation('sexe', $sexe);
        $animal->setRelation('user', $user);
        $animal->setRelation('vaccinations', collect());

        return $animal;
    }

    public function test_fromModel_maps_scalar_fields(): void
    {
        $animal = $this->makeFullAnimal();

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertSame(1, $dto->id);
        $this->assertSame('Rex', $dto->nom);
        $this->assertSame('Labrador', $dto->race);
        $this->assertSame('2020-06-01', $dto->dateNaissance);
        $this->assertSame('10.5', $dto->poids);
    }

    public function test_fromModel_maps_espece_as_EspeceResponseDTO(): void
    {
        $animal = $this->makeFullAnimal();

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertInstanceOf(EspeceResponseDTO::class, $dto->espece);
        $this->assertSame(1, $dto->espece->id);
        $this->assertSame('Chien', $dto->espece->libelle);
    }

    public function test_fromModel_maps_sexe_as_SexeResponseDTO(): void
    {
        $animal = $this->makeFullAnimal();

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertInstanceOf(SexeResponseDTO::class, $dto->sexe);
        $this->assertSame('Mâle', $dto->sexe->libelle);
    }

    public function test_fromModel_maps_user_as_UserRequestDTO(): void
    {
        $animal = $this->makeFullAnimal();

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertInstanceOf(UserRequestDTO::class, $dto->user);
        $this->assertSame(1, $dto->user->id);
    }

    public function test_fromModel_maps_empty_vaccinations(): void
    {
        $animal = $this->makeFullAnimal();

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertCount(0, $dto->vaccinations);
    }

    public function test_fromModel_handles_null_race_and_nullable_fields(): void
    {
        $animal = $this->makeFullAnimal(['race' => null, 'poids' => null, 'dateNaissance' => null]);

        $dto = AnimalResponseDTO::fromModel($animal);

        $this->assertNull($dto->race);
        $this->assertNull($dto->poids);
        $this->assertNull($dto->dateNaissance);
    }

    public function test_age_returns_correct_age_when_dateNaissance_set(): void
    {
        $birthDate  = Carbon::now()->subYears(3)->format('Y-m-d');
        $animal     = $this->makeFullAnimal(['dateNaissance' => $birthDate]);
        $dto        = AnimalResponseDTO::fromModel($animal);

        $this->assertSame(3, $dto->age());
    }

    public function test_age_returns_null_when_dateNaissance_is_null(): void
    {
        $animal = $this->makeFullAnimal(['dateNaissance' => null]);
        $dto    = AnimalResponseDTO::fromModel($animal);

        $this->assertNull($dto->age());
    }
}


