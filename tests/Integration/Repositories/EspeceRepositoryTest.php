<?php

namespace Tests\Integration\Repositories;

use App\Models\Espece;
use App\Repositories\EspeceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EspeceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EspeceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EspeceRepository();
    }

    public function test_findAll_returns_all_especes(): void
    {
        Espece::factory()->count(3)->create();

        $result = $this->repository->findAll();

        $this->assertCount(3, $result);
    }

    public function test_findAll_returns_empty_collection_when_none(): void
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }

    public function test_findAll_returns_especes_with_correct_libelle(): void
    {
        Espece::factory()->create(['libelle' => 'Tortue']);

        $result = $this->repository->findAll();

        $this->assertSame('Tortue', $result->first()->libelle);
    }

    public function test_findAll_returns_correct_count_after_multiple_insertions(): void
    {
        Espece::factory()->create(['libelle' => 'Chien']);
        Espece::factory()->create(['libelle' => 'Chat']);

        $result = $this->repository->findAll();

        $this->assertCount(2, $result);
        $libellesFound = $result->pluck('libelle')->toArray();
        $this->assertContains('Chien', $libellesFound);
        $this->assertContains('Chat', $libellesFound);
    }
}

