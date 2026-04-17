<?php

namespace Tests\Unit\Services;

use App\DTOs\Requests\UpdateUserDTO;
use App\DTOs\Requests\VeterinaireCreateDTO;
use App\DTOs\Requests\VeterinaireUpdateDTO;
use App\DTOs\Response\LangueResponseDTO;
use App\DTOs\Response\VeterinaireResponseDTO;
use App\Models\Langue;
use App\Models\User;
use App\Models\Vet;
use App\Repositories\VeterinaireRepository;
use App\Services\VeterinaireService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class VeterinaireServiceTest extends TestCase
{
    private VeterinaireRepository $repoMock;
    private VeterinaireService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repoMock = Mockery::mock(VeterinaireRepository::class);
        $this->service  = new VeterinaireService($this->repoMock);
    }

    private function makeFullVet(array $override = []): Vet
    {
        $user = User::factory()->make(['id' => 1, 'prenom' => 'P', 'nom' => 'V',
            'email' => 'p@v.com', 'numero' => '0600', 'adresse' => '1 r']);
        $vet  = Vet::factory()->make(array_merge([
            'id' => 1, 'user_id' => 1,
            'numeroLicence' => 'LIC-001', 'nomClinique' => 'Clin', 'adresseClinique' => '1 av',
            'NbAnsExperience' => 5, 'dateDeNaissance' => '1980-01-01',
            'licenceExpiration' => '2030-01-01', 'certification' => 'CPAV',
        ], $override));
        $vet->setRelation('user', $user);
        $vet->setRelation('langues', collect());

        return $vet;
    }


    public function test_createVeterinarian_calls_repository_create_with_user_id(): void
    {
        $dto = new VeterinaireCreateDTO(
            'LIC-002', 'Clinique B', '5 rue', 3,
            '1990-01-01', '2029-12-31', 'Cert'
        );

        $vet = $this->makeFullVet();
        $repoMock = Mockery::mock(VeterinaireRepository::class);
        $repoMock->shouldReceive('create')
            ->once()
            ->withArgs(fn($data) => $data['user_id'] === 42 && $data['numeroLicence'] === 'LIC-002')
            ->andReturn($vet);

        $result = $this->service->createVeterinarian($dto, 42, $repoMock);

        $this->assertInstanceOf(Vet::class, $result);
    }


    public function test_getAllVets_calls_findActiveVets_on_repository(): void
    {
        $paginator = new LengthAwarePaginator([], 0, 8);
        $this->repoMock->shouldReceive('findActiveVets')->once()->andReturn($paginator);

        $this->service->getAllVets();

        $this->assertTrue(true);
    }

    public function test_getAllVets_returns_paginator_with_no_items_when_none(): void
    {
        $paginator = new LengthAwarePaginator([], 0, 8);
        $this->repoMock->shouldReceive('findActiveVets')->once()->andReturn($paginator);

        $result = $this->service->getAllVets();

        $this->assertCount(0, $result->items());
    }

    public function test_getAllVets_maps_single_vet_to_VeterinaireResponseDTO(): void
    {
        $vet       = $this->makeFullVet();
        $paginator = new LengthAwarePaginator([$vet], 1, 8);
        $this->repoMock->shouldReceive('findActiveVets')->once()->andReturn($paginator);

        $result = $this->service->getAllVets();
        $items  = $result->items();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(VeterinaireResponseDTO::class, $items[0]);
        $this->assertSame('LIC-001', $items[0]->numeroLicence);
    }

    public function test_getAllVets_maps_multiple_vets_to_DTOs(): void
    {
        $vet1 = $this->makeFullVet(['id' => 1, 'numeroLicence' => 'LIC-001']);
        $vet2 = $this->makeFullVet(['id' => 2, 'numeroLicence' => 'LIC-002']);
        $paginator = new LengthAwarePaginator([$vet1, $vet2], 2, 8);
        $this->repoMock->shouldReceive('findActiveVets')->once()->andReturn($paginator);

        $result = $this->service->getAllVets();
        $items  = $result->items();

        $this->assertCount(2, $items);
        $this->assertInstanceOf(VeterinaireResponseDTO::class, $items[0]);
        $this->assertInstanceOf(VeterinaireResponseDTO::class, $items[1]);
        $this->assertSame('LIC-001', $items[0]->numeroLicence);
        $this->assertSame('LIC-002', $items[1]->numeroLicence);
    }

    public function test_getAllVets_preserves_pagination_metadata(): void
    {
        $vets = array_map(fn($i) => $this->makeFullVet(['id' => $i, 'numeroLicence' => "LIC-00$i"]),
            range(1, 8));
        $paginator = new LengthAwarePaginator($vets, 20, 8, 1);
        $this->repoMock->shouldReceive('findActiveVets')->once()->andReturn($paginator);

        $result = $this->service->getAllVets();

        $this->assertSame(20, $result->total());
        $this->assertSame(8,  $result->perPage());
        $this->assertCount(8, $result->items());
    }


    public function test_getVet_returns_VeterinaireResponseDTO(): void
    {
        $vet = $this->makeFullVet(['id' => 5]);
        $this->repoMock->shouldReceive('findVet')->with(5)->once()->andReturn($vet);

        $result = $this->service->getVet(5);

        $this->assertInstanceOf(VeterinaireResponseDTO::class, $result);
        $this->assertSame(5, $result->id);
    }



    public function test_editLangues_syncs_langues_from_request(): void
    {
        $vetUser    = User::factory()->make(['id' => 1]);
        $vetProfile = Vet::factory()->make(['id' => 10, 'user_id' => 1]);
        $vetUser->setRelation('vet', $vetProfile);


        $languesMock = Mockery::mock();
        $languesMock->shouldReceive('sync')->once()->with([1, 2]);


        $vetMock = Mockery::mock();
        $vetMock->shouldReceive('langues')->andReturn($languesMock);

        $this->repoMock->shouldReceive('findVet')->with(10)->once()->andReturn($vetMock);

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('input')->with('langues', [])->once()->andReturn([1, 2]);

        $this->service->editLangues($requestMock,10);

        $this->assertTrue(true);
    }

    public function test_editLangues_syncs_empty_array_when_no_langues_in_request(): void
    {
        $languesMock = Mockery::mock();
        $languesMock->shouldReceive('sync')->once()->with([]);

        $vetMock = Mockery::mock();
        $vetMock->shouldReceive('langues')->andReturn($languesMock);
        $this->repoMock->shouldReceive('findVet')->with(10)->andReturn($vetMock);

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('input')->with('langues', [])->andReturn([]);

        $this->service->editLangues($requestMock, 10);

        $this->assertTrue(true);
    }

    public function test_update_profile()
    {
        $vet = $this->makeFullVet();
        $user = $vet->user;
        $user->setRelation('vet', $vet);

        $this->actingAs($user);

        $vetDto = new VeterinaireUpdateDTO(
            'new Clinic',
            $vet->numeroLicence,
            $vet->NbAnsExperience,
            $vet->dateDeNaissance,
            $vet->certification,
        );
        $userDto = new UpdateUserDTO(
            $user->prenom,
            $user->nom,
            $user->email,
            $user->numero,
            'new address',
        );

        $repo = Mockery::mock(VeterinaireRepository::class);

        $repo->shouldReceive('findVet')
            ->once()
            ->with($vet->id)
            ->andReturn($vet);

        $repo->shouldReceive('updateVet')
            ->once()
            ->with($vet, $vetDto->toArray());

        $repo->shouldReceive('updateUserInfo')
            ->once()
            ->with($vet, $userDto->toArray());

        $service = new VeterinaireService($repo);

        $service->updateProfile($vetDto, $userDto);

        $this->assertTrue(true);
    }


    public function test_get_pending_vets()
    {

        $repo = Mockery::mock(VeterinaireRepository::class);

        $repo->shouldReceive('findPendingVets')
            ->once()
            ->andReturn(new LengthAwarePaginator([], 0, 10))
        ;

        $service = new VeterinaireService($repo);
        $service->getPendingVets();

        $this->assertTrue(true);


    }
}


