<?php

namespace Tests\Unit\Services;

use App\Repositories\LangueRepository;
use App\Services\LangueService;
use App\Models\Langue;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class LangueServiceTest extends TestCase
{
    private LangueRepository $repoMock;
    private LangueService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(LangueRepository::class);
        $this->service  = new LangueService($this->repoMock);
    }

    public function test_getLangues_returns_empty_collection_when_none(): void
    {
        $this->repoMock->shouldReceive('findAll')->once()->andReturn(collect());

        $result = $this->service->getLangues();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }

    public function test_getLangues_maps_each_langue_to_LangueResponseDTO(): void
    {
        $langue = Langue::factory()->make(['id' => 1, 'libelle' => 'Français']);
        $this->repoMock->shouldReceive('findAll')->once()->andReturn(collect([$langue]));

        $result = $this->service->getLangues();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(\App\DTOs\Response\LangueResponseDTO::class, $result->first());
        $this->assertSame('Français', $result->first()->libelle);
    }

    public function test_getLangues_maps_multiple_langues(): void
    {
        $langues = collect([
            Langue::factory()->make(['id' => 1, 'libelle' => 'Français']),
            Langue::factory()->make(['id' => 2, 'libelle' => 'Anglais']),
        ]);
        $this->repoMock->shouldReceive('findAll')->once()->andReturn($langues);

        $result = $this->service->getLangues();

        $this->assertCount(2, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

