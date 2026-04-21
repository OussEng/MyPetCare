<?php

namespace Tests\Integration\Repositories;

use App\Models\Sexe;
use App\Repositories\SexeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SexeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private SexeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new SexeRepository();
    }

    public function test_findSexes_returns_all_sexes(): void
    {
        Sexe::factory()->count(2)->create();

        $result = $this->repository->findSexes();

        $this->assertCount(2, $result);
    }

    public function test_findSexes_returns_empty_collection_when_none(): void
    {
        $result = $this->repository->findSexes();

        $this->assertCount(0, $result);
    }

    public function test_findSexes_returns_correct_libelle(): void
    {
        Sexe::factory()->create(['libelle' => 'Mâle']);

        $result = $this->repository->findSexes();

        $this->assertSame('Mâle', $result->first()->libelle);
    }

    public function test_findSexes_returns_male_and_femelle(): void
    {
        Sexe::factory()->create(['libelle' => 'Mâle']);
        Sexe::factory()->create(['libelle' => 'Femelle']);

        $result = $this->repository->findSexes();

        $libellesList = $result->pluck('libelle')->toArray();
        $this->assertContains('Mâle', $libellesList);
        $this->assertContains('Femelle', $libellesList);
    }
}

