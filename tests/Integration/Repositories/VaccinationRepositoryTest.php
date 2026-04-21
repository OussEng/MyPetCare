<?php

namespace Tests\Integration\Repositories;

use App\Models\Espece;
use App\Models\Vaccination;
use App\Repositories\VaccinationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VaccinationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private VaccinationRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VaccinationRepository();
    }


    public function test_findAll_returns_all_vaccinations(): void
    {
        Vaccination::factory()->count(3)->create();

        $result = $this->repository->findAll();

        $this->assertCount(3, $result);
    }

    public function test_findAll_returns_empty_collection_when_none(): void
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }


    public function test_findById_returns_correct_vaccination(): void
    {
        $vac = Vaccination::factory()->create(['nom_vaccine' => 'Rabies', 'info' => 'Info test']);

        $result = $this->repository->findById($vac->id);

        $this->assertSame($vac->id, $result->id);
        $this->assertSame('Rabies', $result->nom_vaccine);
    }

    public function test_findById_throws_ModelNotFoundException_for_unknown_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->findById(99999);
    }

    public function test_findAll_returns_vaccinations_with_correct_data(): void
    {
        $espece = Espece::factory()->create();
        Vaccination::factory()->create(['nom_vaccine' => 'Parvovirus', 'info' => 'Info', 'espece_id' => $espece->id]);

        $result = $this->repository->findAll();

        $this->assertSame('Parvovirus', $result->first()->nom_vaccine);
    }
}

