<?php

namespace Tests\Unit\Services;

use App\Repositories\EspeceRepository;
use App\Services\EspeceService;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class EspeceServiceTest extends TestCase
{
    private EspeceRepository $repoMock;
    private EspeceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(EspeceRepository::class);
        $this->service  = new EspeceService($this->repoMock);
    }

    public function test_getEspeces_returns_empty_collection_when_no_especes(): void
    {
        $this->repoMock->shouldReceive('findAll')->once()->andReturn(collect());

        $result = $this->service->getEspeces();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }

    public function test_getEspeces_calls_findAll_once(): void
    {
        $this->repoMock->shouldReceive('findAll')->once()->andReturn(collect());

        $this->service->getEspeces();

        $this->assertTrue(true);
    }

    public function test_getEspeces_maps_each_espece_to_EspeceResponseDTO(): void
    {
        $espece = \App\Models\Espece::factory()->make(['id' => 1, 'libelle' => 'Chien']);
        $espece->setRelation('vaccinations', collect());

        $this->repoMock->shouldReceive('findAll')->once()->andReturn(collect([$espece]));

        $result = $this->service->getEspeces();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(\App\DTOs\Response\Espece\EspeceResponseDTO::class, $result->first());
        $this->assertSame('Chien', $result->first()->libelle);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

