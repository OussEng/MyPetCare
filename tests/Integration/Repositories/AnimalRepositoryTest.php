<?php

namespace Tests\Integration\Repositories;

use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\User;
use App\Repositories\AnimalRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AnimalRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AnimalRepository();
    }


    public function test_findAllbyUser_returns_only_animals_for_given_user(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Animal::factory()->count(3)->create(['user_id' => $user1->id]);
        Animal::factory()->count(2)->create(['user_id' => $user2->id]);

        $result = $this->repository->findAllbyUser($user1->id);

        $this->assertCount(3, $result);
        $result->each(fn($a) => $this->assertSame($user1->id, $a->user_id));
    }

    public function test_findAllbyUser_returns_empty_collection_when_no_animals(): void
    {
        $user = User::factory()->create();

        $result = $this->repository->findAllbyUser($user->id);

        $this->assertCount(0, $result);
    }


    public function test_findById_returns_correct_animal(): void
    {
        $animal = Animal::factory()->create(['nom' => 'Buddy']);

        $result = $this->repository->findById($animal->id);

        $this->assertSame($animal->id, $result->id);
        $this->assertSame('Buddy', $result->nom);
    }

    public function test_findById_throws_ModelNotFoundException_for_unknown_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->findById(99999);
    }


    public function test_create_persists_animal_in_database(): void
    {
        $user   = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe   = Sexe::factory()->create();

        $data = [
            'nom'           => 'Maxou',
            'espece_id'     => $espece->id,
            'sexe_id'       => $sexe->id,
            'race'          => 'Berger',
            'dateNaissance' => '2021-03-15',
            'poids'         => '25.0',
            'user_id'       => $user->id,
        ];

        $result = $this->repository->create($data);

        $this->assertInstanceOf(Animal::class, $result);
        $this->assertDatabaseHas('animals', ['nom' => 'Maxou', 'user_id' => $user->id]);
    }

    public function test_create_with_minimal_required_fields(): void
    {
        $user   = User::factory()->create();
        $espece = Espece::factory()->create();
        $sexe   = Sexe::factory()->create();

        $data = [
            'nom'       => 'Minou',
            'espece_id' => $espece->id,
            'sexe_id'   => $sexe->id,
            'user_id'   => $user->id,
        ];

        $result = $this->repository->create($data);

        $this->assertDatabaseHas('animals', ['nom' => 'Minou']);
    }


    public function test_delete_removes_animal_from_database(): void
    {
        $animal = Animal::factory()->create();

        $this->repository->delete($animal->id);

        $this->assertDatabaseMissing('animals', ['id' => $animal->id]);
    }

    public function test_delete_only_removes_target_animal(): void
    {
        $animal1 = Animal::factory()->create();
        $animal2 = Animal::factory()->create();

        $this->repository->delete($animal1->id);

        $this->assertDatabaseMissing('animals', ['id' => $animal1->id]);
        $this->assertDatabaseHas('animals', ['id' => $animal2->id]);
    }
}

