<?php

namespace Tests\Unit\Services;

use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\Http\Requests\AnimalRequest;
use App\Http\Requests\AnimalUpdateRequest;
use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Repositories\AnimalRepository;
use App\Services\AnimalService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Tests\TestCase;

class AnimalServiceTest extends TestCase
{
    private AnimalRepository $repoMock;
    private AnimalService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(AnimalRepository::class);
        $this->service  = new AnimalService($this->repoMock);
    }

    private function makeFullAnimal(array $override = []): Animal
    {
        $espece = Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());
        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);
        $user = User::factory()->make(['id' => 1, 'prenom' => 'Jean', 'nom' => 'D',
            'email' => 'j@t.com', 'numero' => '0600', 'adresse' => '1 r']);

        $animal = Animal::factory()->make(array_merge([
            'id'        => 1,
            'nom'       => 'Rex',
            'sexe_id'   => 1,
            'espece_id' => 1,
            'user_id'   => 1,
        ], $override));
        $animal->setRelation('espece', $espece);
        $animal->setRelation('sexe', $sexe);
        $animal->setRelation('user', $user);
        $animal->setRelation('vaccinations', collect());

        return $animal;
    }


    public function test_create_returns_animal_model(): void
    {
        $requestMock = Mockery::mock(AnimalRequest::class);
        $requestMock->shouldReceive('validated')->andReturn([
            'nom' => 'Rex', 'espece_id' => 1, 'race' => null,
            'dateNaissance' => null, 'poids' => null, 'sexe_id' => 1, 'user_id' => 1,
        ]);

        $animal = Animal::factory()->make([
            'id'        => 1,
            'nom'       => 'Rex',
            'sexe_id'   => 1,
            'espece_id' => 1,
            'user_id'   => 1,
        ]);
        $this->repoMock->shouldReceive('create')->once()->andReturn($animal);

        $result = $this->service->create($requestMock);

        $this->assertInstanceOf(Animal::class, $result);
        $this->assertSame('Rex', $result->nom);
    }


    public function test_getAllAnimalsByUser_returns_empty_collection_when_none(): void
    {
        $this->repoMock->shouldReceive('findAllbyUser')->with(1)->once()->andReturn(collect());

        $result = $this->service->getAllanimalsByUser(1);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }

    public function test_getAllAnimalsByUser_maps_to_AnimalResponseDTOs(): void
    {
        $animal = $this->makeFullAnimal();
        $this->repoMock->shouldReceive('findAllbyUser')->with(5)->once()->andReturn(collect([$animal]));

        $result = $this->service->getAllanimalsByUser(5);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(AnimalResponseDTO::class, $result->first());
        $this->assertSame('Rex', $result->first()->nom);
    }

    public function test_getAllAnimalsByUser_passes_correct_user_id(): void
    {
        $this->repoMock->shouldReceive('findAllbyUser')->with(99)->once()->andReturn(collect());

        $this->service->getAllanimalsByUser(99);

        $this->assertTrue(true);
    }


    public function test_getAnimalById_authorized_returns_AnimalResponseDTO(): void
    {
        $animal = $this->makeFullAnimal(['id' => 7]);
        $this->repoMock->shouldReceive('findById')->with(7)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('view', $animal)->once()->andReturn(true);

        $result = $this->service->getAnimalById(7);

        $this->assertInstanceOf(AnimalResponseDTO::class, $result);
        $this->assertSame('Rex', $result->nom);
    }

    public function test_getAnimalById_unauthorized_throws_AuthorizationException(): void
    {
        $this->expectException(AuthorizationException::class);

        $animal = $this->makeFullAnimal(['id' => 7]);
        $this->repoMock->shouldReceive('findById')->with(7)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('view', $animal)->once()
            ->andThrow(new AuthorizationException());

        $this->service->getAnimalById(7);
    }


    public function test_deleteAnimal_authorized_calls_repository_delete(): void
    {
        $animal = $this->makeFullAnimal(['id' => 3]);
        $this->repoMock->shouldReceive('findById')->with(3)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('delete', $animal)->once()->andReturn(true);
        $this->repoMock->shouldReceive('delete')->with(3)->once();

        $this->service->deleteAnimal(3);

        $this->assertTrue(true);
    }

    public function test_deleteAnimal_unauthorized_throws_AuthorizationException(): void
    {
        $this->expectException(AuthorizationException::class);

        $animal = $this->makeFullAnimal(['id' => 3]);
        $this->repoMock->shouldReceive('findById')->with(3)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('delete', $animal)->once()
            ->andThrow(new AuthorizationException());

        $this->service->deleteAnimal(3);
    }

    public function test_deleteAnimal_does_not_call_delete_when_unauthorized(): void
    {
        $animal = $this->makeFullAnimal(['id' => 3]);
        $this->repoMock->shouldReceive('findById')->with(3)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->andThrow(new AuthorizationException());
        $this->repoMock->shouldReceive('delete')->never();

        try {
            $this->service->deleteAnimal(3);
        } catch (AuthorizationException) {
        }

        $this->assertTrue(true);
    }

    public function test_updateAnimal_authorized_returns_updated_animal(): void
    {
        $animal = $this->makeFullAnimal(['id' => 4, 'nom' => 'Rex']);

        $requestMock = Mockery::mock(AnimalUpdateRequest::class);
        $requestMock->shouldReceive('validated')->andReturn([
            'nom' => 'Max', 'espece_id' => 1, 'race' => null,
            'dateNaissance' => null, 'poids' => null, 'sexe_id' => 1,
        ]);

        $this->repoMock->shouldReceive('findById')->with(4)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('update', $animal)->once()->andReturn(true);

        $updatedAnimal = $this->makeFullAnimal(['id' => 4, 'nom' => 'Max']);
        $this->repoMock->shouldReceive('update')->with(4, Mockery::any())->once()->andReturn($updatedAnimal);

        $result = $this->service->updateAnimal(4, $requestMock);

        $this->assertInstanceOf(Animal::class, $result);
        $this->assertSame('Max', $result->nom);
    }

    public function test_updateAnimal_calls_repository_with_validated_data(): void
    {
        $validatedData = [
            'nom' => 'Buddy', 'espece_id' => 2, 'race' => 'Berger',
            'dateNaissance' => '2021-05-10', 'poids' => '8', 'sexe_id' => 1,
        ];

        $animal = $this->makeFullAnimal(['id' => 5]);

        $requestMock = Mockery::mock(AnimalUpdateRequest::class);
        $requestMock->shouldReceive('validated')->once()->andReturn($validatedData);

        $this->repoMock->shouldReceive('findById')->with(5)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('update', $animal)->once()->andReturn(true);
        $this->repoMock->shouldReceive('update')->with(5, $validatedData)->once()->andReturn($animal);

        $this->service->updateAnimal(5, $requestMock);

        $this->assertTrue(true);
    }

    public function test_updateAnimal_unauthorized_throws_AuthorizationException(): void
    {
        $this->expectException(AuthorizationException::class);

        $animal = $this->makeFullAnimal(['id' => 6]);
        $requestMock = Mockery::mock(AnimalUpdateRequest::class);

        $this->repoMock->shouldReceive('findById')->with(6)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->with('update', $animal)->once()
            ->andThrow(new AuthorizationException());

        $this->service->updateAnimal(6, $requestMock);
    }

    public function test_updateAnimal_does_not_call_update_when_unauthorized(): void
    {
        $animal = $this->makeFullAnimal(['id' => 6]);
        $requestMock = Mockery::mock(AnimalUpdateRequest::class);

        $this->repoMock->shouldReceive('findById')->with(6)->once()->andReturn($animal);
        Gate::shouldReceive('authorize')->andThrow(new AuthorizationException());
        $this->repoMock->shouldReceive('update')->never();

        try {
            $this->service->updateAnimal(6, $requestMock);
        } catch (AuthorizationException) {
        }

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}



