<?php

namespace Tests\Unit\DTOs;

use App\DTOs\Response\AnimalResponseDTO;
use App\DTOs\Response\RendezVousResponseDTO;
use App\DTOs\Response\UserResponseDTO;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResponseDTOTest extends TestCase
{
    use RefreshDatabase;
    private function makeUserWithRelations(): User
    {
        $user = User::factory()->make([
            'id'      => 5,
            'prenom'  => 'Sophie',
            'nom'     => 'Leclerc',
            'email'   => 'sophie@example.com',
            'numero'  => '0699999999',
            'adresse' => '3 allée des Roses',
        ]);
        $user->setRelation('animals', collect());
        $user->setRelation('rendervous', collect());

        return $user;
    }

    public function test_fromModel_maps_scalar_fields(): void
    {
        $user = $this->makeUserWithRelations();

        $dto = UserResponseDTO::fromModel($user);

        $this->assertSame('5', $dto->id);  // UserResponseDTO::$id is typed string
        $this->assertSame('Sophie', $dto->prenom);
        $this->assertSame('Leclerc', $dto->nom);
        $this->assertSame('sophie@example.com', $dto->email);
        $this->assertSame('0699999999', $dto->numero);
        $this->assertSame('3 allée des Roses', $dto->adresse);
    }

    public function test_fromModel_maps_empty_animals_collection(): void
    {
        $user = $this->makeUserWithRelations();

        $dto = UserResponseDTO::fromModel($user);

        $this->assertCount(0, $dto->animaux);
    }

    public function test_fromModel_maps_empty_rendezVous_collection(): void
    {
        $user = $this->makeUserWithRelations();

        $dto = UserResponseDTO::fromModel($user);

        $this->assertCount(0, $dto->rendezVous);
    }

    public function test_fromModel_maps_animals_as_AnimalResponseDTOs(): void
    {
        $user   = $this->makeUserWithRelations();
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());
        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);

        $animal = Animal::factory()->make(['id' => 1, 'nom' => 'Max']);
        $animal->setRelation('espece', $espece);
        $animal->setRelation('sexe', $sexe);
        $animal->setRelation('user', $user);
        $animal->setRelation('vaccinations', collect());

        $user->setRelation('animals', collect([$animal]));

        $dto = UserResponseDTO::fromModel($user);

        $this->assertCount(1, $dto->animaux);
        $this->assertInstanceOf(AnimalResponseDTO::class, $dto->animaux->first());
        $this->assertSame('Max', $dto->animaux->first()->nom);
    }
}


