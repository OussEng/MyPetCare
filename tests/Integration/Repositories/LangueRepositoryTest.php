<?php

namespace Tests\Integration\Repositories;

use App\Models\Langue;
use App\Repositories\LangueRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LangueRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private LangueRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new LangueRepository();
    }

    public function test_findAll_returns_all_langues(): void
    {
        Langue::factory()->count(3)->create();

        $result = $this->repository->findAll();

        $this->assertCount(3, $result);
    }

    public function test_findAll_returns_empty_collection_when_none(): void
    {
        $result = $this->repository->findAll();

        $this->assertCount(0, $result);
    }

    public function test_findAll_returns_correct_libelle(): void
    {
        Langue::factory()->create(['libelle' => 'Swahili']);

        $result = $this->repository->findAll();

        $this->assertSame('Swahili', $result->first()->libelle);
    }

    public function test_findAll_returns_all_after_multiple_inserts(): void
    {
        Langue::factory()->create(['libelle' => 'Français']);
        Langue::factory()->create(['libelle' => 'Anglais']);
        Langue::factory()->create(['libelle' => 'Arabe']);

        $result = $this->repository->findAll();

        $this->assertCount(3, $result);
        $this->assertContains('Anglais', $result->pluck('libelle')->toArray());
    }
}

