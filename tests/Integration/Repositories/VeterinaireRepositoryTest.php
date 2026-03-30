<?php

namespace Tests\Integration\Repositories;

use App\Models\User;
use App\Models\Vet;
use App\Repositories\VeterinaireRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VeterinaireRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private VeterinaireRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VeterinaireRepository();
    }


    public function test_create_persists_vet_in_database(): void
    {
        $user = User::factory()->create();
        $data = Vet::factory()->make(['user_id' => $user->id])->toArray();

        $result = $this->repository->create($data);

        $this->assertInstanceOf(Vet::class, $result);
        $this->assertDatabaseHas('veterinaires', ['user_id' => $user->id]);
    }

    public function test_create_stores_licence_number(): void
    {
        $user = User::factory()->create();
        $data = Vet::factory()->make(['user_id' => $user->id, 'numeroLicence' => 'LIC-9999'])->toArray();

        $result = $this->repository->create($data);

        $this->assertSame('LIC-9999', $result->numeroLicence);
    }


    public function test_findAllVets_returns_all_vets(): void
    {
        User::factory()->count(3)->create()->each(function ($user) {
            Vet::factory()->create(['user_id' => $user->id]);
        });

        $result = $this->repository->findAllVets();

        $this->assertCount(3, $result);
    }

    public function test_findAllVets_returns_empty_collection_when_none(): void
    {
        $result = $this->repository->findAllVets();

        $this->assertCount(0, $result);
    }


    public function test_findVet_returns_correct_vet(): void
    {
        $user = User::factory()->create();
        $vet  = Vet::factory()->create(['user_id' => $user->id, 'numeroLicence' => 'LIC-7777']);

        $result = $this->repository->findVet($vet->id);

        $this->assertSame($vet->id, $result->id);
        $this->assertSame('LIC-7777', $result->numeroLicence);
    }

    public function test_findVet_throws_ModelNotFoundException_for_unknown_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->findVet(99999);
    }
}

