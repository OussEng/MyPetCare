<?php

namespace Tests\Unit\Services;

use App\Models\Sexe;
use App\Repositories\SexeRepository;
use App\Services\SexeServices;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class SexeServicesTest extends TestCase
{
    private SexeRepository $repoMock;
    private SexeServices $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(SexeRepository::class);
        $this->service  = new SexeServices($this->repoMock);
    }

    public function test_getSexes_returns_empty_collection_when_none(): void
    {
        $this->repoMock->shouldReceive('findSexes')->once()->andReturn(collect());

        $result = $this->service->getSexes();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }

    public function test_getSexes_maps_each_sexe_to_SexeResponseDTO(): void
    {
        $sexe = Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']);
        $this->repoMock->shouldReceive('findSexes')->once()->andReturn(collect([$sexe]));

        $result = $this->service->getSexes();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(\App\DTOs\Response\SexeResponseDTO::class, $result->first());
        $this->assertSame('Mâle', $result->first()->libelle);
    }

    public function test_getSexes_maps_multiple_sexes(): void
    {
        $sexes = collect([
            Sexe::factory()->make(['id' => 1, 'libelle' => 'Mâle']),
            Sexe::factory()->make(['id' => 2, 'libelle' => 'Femelle']),
        ]);
        $this->repoMock->shouldReceive('findSexes')->once()->andReturn($sexes);

        $result = $this->service->getSexes();

        $this->assertCount(2, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

