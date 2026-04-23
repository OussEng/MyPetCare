<?php

namespace Tests\Unit\Services;

use App\DTOs\Requests\User\UserRequestDTO;
use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\DTOs\Response\Espece\EspeceResponseDTO;
use App\DTOs\Response\Sexe\SexeResponseDTO;
use App\DTOs\Response\User\UserSimpleDTO;
use App\DTOs\Response\Veterinaire\VeterinaireResponseDTO;
use App\Enums\Etat;
use App\Http\Requests\RendezVousRequest;
use App\Managers\RendezVousManager;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use App\Repositories\RendezVousRepository;
use App\Services\AnimalService;
use App\Services\RendezVousService;
use App\Services\VeterinaireService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class RendezVousServiceTest extends TestCase
{
    private RendezVousRepository $rvRepoMock;
    private VeterinaireService $vetServiceMock;
    private AnimalService $animalServiceMock;
    private RendezVousService $service;
    private RendezVousManager $rendezVousManagerMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rvRepoMock       = Mockery::mock(RendezVousRepository::class);
        $this->vetServiceMock   = Mockery::mock(VeterinaireService::class);
        $this->animalServiceMock = Mockery::mock(AnimalService::class);
        $this->rendezVousManagerMock = Mockery::mock(RendezVousManager::class);
        $this->service = new RendezVousService(
            $this->rvRepoMock,
            $this->vetServiceMock,
            $this->animalServiceMock,
            $this->rendezVousManagerMock
        );
    }

    private function makeVetUser(int $vetId = 10): User
    {
        $vetUser    = User::factory()->make(['id' => 1]);
        $vetProfile = Vet::factory()->make(['id' => $vetId, 'user_id' => 1]);
        $vetUser->setRelation('vet', $vetProfile);

        return $vetUser;
    }

    private function makeVetResponseDTO(): VeterinaireResponseDTO
    {
        $userDto = new UserSimpleDTO(1, 'P', 'V', 'p@v.com', '0600', '1 r',"2 rue de france", null);

        return new VeterinaireResponseDTO(
            1, $userDto, 'LIC-001', 'Clin', '1 av', 5,
            '1980-01-01', '2030-01-01', 'CPAV', collect(), 1
        );
    }

    private function makeAnimalResponseDTO(): AnimalResponseDTO
    {
        $especeDto = new EspeceResponseDTO(1, 'Chien', collect());
        $sexeDto   = new SexeResponseDTO(1, 'Mâle');
        $userDto   = new UserSimpleDTO(1, 'J', 'D', 'j@t.com', '0600', '0202020202', "2 rue de france", null);

        return new AnimalResponseDTO(1, 'Rex', null, $especeDto, null, null, $sexeDto, $userDto, collect());
    }

    private function makeBuilderMock(Collection $items = null): \Mockery\MockInterface
    {
        $items     = $items ?? collect();
        $paginator = new LengthAwarePaginator($items, $items->count(), 10);

        $mock = Mockery::mock();
        $mock->shouldReceive('where')->andReturnSelf();
        $mock->shouldReceive('whereIn')->andReturnSelf();
        $mock->shouldReceive('paginate')->andReturn($paginator);
        $mock->shouldReceive('withQueryString')->andReturnSelf();
        $mock->shouldReceive('pluck')->andReturn(collect());

        return $mock;
    }

    // --- calculateAvailableSlots() ---

    public function test_calculateAvailableSlots_returns_8_slots_for_a_given_date(): void
    {
        $slots = $this->service->calculateAvailableSlots('2026-05-10', collect());

        $this->assertCount(8, $slots);
    }

    public function test_calculateAvailableSlots_slots_start_at_9am(): void
    {
        $slots = array_values($this->service->calculateAvailableSlots('2026-05-10', collect()));

        $this->assertStringContainsString('09:00:00', $slots[0]);
    }

    public function test_calculateAvailableSlots_returns_empty_array_when_no_date(): void
    {
        $slots = $this->service->calculateAvailableSlots(null, collect());

        $this->assertCount(0, $slots);
    }

    public function test_calculateAvailableSlots_excludes_already_booked_slots(): void
    {
        $bookedSlot = Carbon::parse('2026-05-10')->setTime(9, 0)->toDateTimeString();
        $booked     = collect([(object)['dateHeureDebut' => $bookedSlot]]);

        $slots = $this->service->calculateAvailableSlots('2026-05-10', $booked);

        $this->assertNotContains($bookedSlot, $slots);
        $this->assertCount(7, $slots);
    }

    public function test_calculateAvailableSlots_all_slots_booked_returns_empty(): void
    {
        $date   = '2026-05-10';
        $day    = Carbon::parse($date)->setTime(9, 0);
        $booked = collect();

        for ($i = 0; $i <= 7; $i++) {
            $booked->push((object)['dateHeureDebut' => $day->copy()->toDateTimeString()]);
            $day->addMinutes(60);
        }

        $slots = $this->service->calculateAvailableSlots($date, $booked);

        $this->assertCount(0, $slots);
    }


    public function test_getAvailableSlotsForVet_returns_expected_keys(): void
    {
        $vetDto    = $this->makeVetResponseDTO();
        $animalDto = $this->makeAnimalResponseDTO();

        $this->vetServiceMock->shouldReceive('getVet')->with(1)->once()->andReturn($vetDto);
        $this->rvRepoMock->shouldReceive('findAllByVet')->with(1)->once()->andReturn(collect());
        $this->animalServiceMock->shouldReceive('getAllanimalsByUser')->with(5)->once()->andReturn(collect([$animalDto]));

        $result = $this->service->getAvailableSlotsForVet(1, 5, '2026-05-10');

        $this->assertArrayHasKey('selectedDate', $result);
        $this->assertArrayHasKey('slots', $result);
        $this->assertArrayHasKey('animaux', $result);
        $this->assertArrayHasKey('vet', $result);
        $this->assertSame('2026-05-10', $result['selectedDate']);
        $this->assertInstanceOf(VeterinaireResponseDTO::class, $result['vet']);
    }


    public function test_create_delegates_to_repository(): void
    {
        $rv = RendezVous::factory()->make([
            'id'             => 1,
            'motif'          => 'Consultation',
            'user_id'        => 1,
            'animal_id'      => 1,
            'veterinaire_id' => 1,
            'etat'           => Etat::CONFIRMER,
        ]);

        $requestMock = Mockery::mock(RendezVousRequest::class);
        $requestMock->shouldReceive('validated')->andReturn([
            'dateHeureDebut' => '2026-05-01 10:00:00',
            'motif'          => 'Consultation',
            'user_id'        => 1,
            'veterinaire_id' => 2,
            'animal_id'      => 3,
        ]);

        $this->rvRepoMock->shouldReceive('create')->once()->andReturn($rv);

        $result = $this->service->create($requestMock);

        $this->assertInstanceOf(RendezVous::class, $result);
    }


    public function test_getTodaysApointement_returns_collection(): void
    {
        $this->rvRepoMock->shouldReceive('findTodayApointement')->once()->andReturn(collect());

        $result = $this->service->getTodaysApointement();

        $this->assertInstanceOf(Collection::class, $result);
    }


    public function test_getPendingAponintements_returns_empty_collection_when_none(): void
    {
        $this->rvRepoMock->shouldReceive('findPending')->once()->andReturn(collect());

        $result = $this->service->getPendingAponintements();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }


    public function test_getRendezVousByUser_returns_paginator(): void
    {
        $paginator = new LengthAwarePaginator(collect(), 0, 10);

        $request = new Request();

        $this->rvRepoMock
            ->shouldReceive('findAllByUser')
            ->with(Mockery::any(), Etat::CONFIRMER, false)
            ->once()
            ->andReturn($paginator);

        Auth::shouldReceive('id')->andReturn(5);
        $this->rendezVousManagerMock->shouldReceive('handleState')->once();

        $result = $this->service->getRendezVousByUser($request);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }


    public function test_getAllApointementsByVet_without_filters_returns_paginator(): void
    {
        $vetUser = $this->makeVetUser(10);
        $this->actingAs($vetUser);

        $builderMock = $this->makeBuilderMock();
        $this->rvRepoMock->shouldReceive('findAllByVet')->with(10)->once()->andReturn($builderMock);
        $this->rendezVousManagerMock->shouldReceive('handleState')->once();

        $result = $this->service->getAllApointementsByVet();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_getAllApointementsByVet_with_valid_etat_filter_applies_where(): void
    {
        $vetUser = $this->makeVetUser(10);
        $this->actingAs($vetUser);

        $builderMock = $this->makeBuilderMock();
        $builderMock->shouldReceive('where')->withArgs(fn($col) => $col === 'etat')->andReturnSelf();
        $this->rvRepoMock->shouldReceive('findAllByVet')->with(10)->once()->andReturn($builderMock);
        $this->rendezVousManagerMock->shouldReceive('handleState')->once();

        $result = $this->service->getAllApointementsByVet(Etat::CONFIRMER->value);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function test_getAllApointementsByVet_with_invalid_etat_ignores_filter(): void
    {
        $vetUser = $this->makeVetUser(10);
        $this->actingAs($vetUser);

        $builderMock = $this->makeBuilderMock();
        $this->rvRepoMock->shouldReceive('findAllByVet')->with(10)->once()->andReturn($builderMock);
        $this->rendezVousManagerMock->shouldReceive('handleState')->once();

        $result = $this->service->getAllApointementsByVet('invalide');

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}


