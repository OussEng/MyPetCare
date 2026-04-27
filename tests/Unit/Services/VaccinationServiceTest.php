<?php

namespace Tests\Unit\Services;

use App\DTOs\Requests\User\UserRequestDTO;
use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\DTOs\Response\Espece\EspeceResponseDTO;
use App\DTOs\Response\Sexe\SexeResponseDTO;
use App\DTOs\Response\User\UserSimpleDTO;
use App\DTOs\Response\Vaccination\VaccinationResponseDTO;
use App\Models\Animal;
use App\Models\Vaccination;
use App\Repositories\AnimalRepository;
use App\Repositories\VaccinationRepository;
use App\Services\AnimalService;
use App\Services\EspeceService;
use App\Services\VaccinationService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class VaccinationServiceTest extends TestCase
{
    private VaccinationRepository $vacRepoMock;
    private AnimalService $animalServiceMock;
    private EspeceService $especeServiceMock;
    private AnimalRepository $animalRepoMock;
    private VaccinationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->vacRepoMock       = Mockery::mock(VaccinationRepository::class);
        $this->animalServiceMock = Mockery::mock(AnimalService::class);
        $this->animalRepoMock    = Mockery::mock(AnimalRepository::class);
        $this->service = new VaccinationService(
            $this->vacRepoMock,
            $this->animalServiceMock,
            $this->animalRepoMock,
        );
    }

    private function makeVaccination(array $override = []): Vaccination
    {
        return Vaccination::factory()->make(array_merge([
            'id' => 1, 'nom_vaccine' => 'Rabies', 'info' => 'Info', 'espece_id' => 1,
        ], $override));
    }

    private function makeAnimalResponseDTO(Collection $vaccinations = null): AnimalResponseDTO
    {
        $especeDto = new EspeceResponseDTO(1, 'Chien', $vaccinations ?? collect());
        $sexeDto   = new SexeResponseDTO(1, 'Mâle');
        $userDto   = new UserRequestDTO(1, 'J', 'D', 'j@t.com', '0600', '1 r');

        return new AnimalResponseDTO(1, 'Rex', null, $especeDto, null, null, $sexeDto, $userDto, collect());
    }


    public function test_getVaccinations_returns_empty_collection_when_none(): void
    {
        $this->vacRepoMock->shouldReceive('findAll')->once()->andReturn(collect());

        $result = $this->service->getVaccinations();

        $this->assertCount(0, $result);
    }

    public function test_getVaccinations_maps_each_vaccination_to_VaccinationResponseDTO(): void
    {
        $vac = $this->makeVaccination();
        $this->vacRepoMock->shouldReceive('findAll')->once()->andReturn(collect([$vac]));

        $result = $this->service->getVaccinations();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(VaccinationResponseDTO::class, $result->first());
        $this->assertSame('Rabies', $result->first()->nom_vaccine);
    }


    public function test_getVaccinationsBySpecies_returns_espece_vaccinations_collection(): void
    {
        $vacDto     = new VaccinationResponseDTO(1, 'Rabies', 'Info');
        $especeDto  = new EspeceResponseDTO(1, 'Chien', collect([$vacDto]));
        $sexeDto    = new SexeResponseDTO(1, 'Mâle');
        $userDto    = new UserSimpleDTO(1, 'J', 'D', 'j@t.com', '0600', '1 r',"2 rue de france", null);
        $animalDto  = new AnimalResponseDTO(1, 'Rex', null, $especeDto, null, null, $sexeDto, $userDto, collect());

        $this->animalServiceMock->shouldReceive('getAnimalById')->with(1)->once()->andReturn($animalDto);

        $result = $this->service->getVaccinationsBySpecies(1);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }


    public function test_addVaccination_calls_syncWithoutDetaching_on_animal_vaccinations(): void
    {
        $vaccinationsMock = Mockery::mock(BelongsToMany::class);
        $vaccinationsMock->shouldReceive('syncWithoutDetaching')->once()->with([3, 5]);

        $animalMock = Mockery::mock(Animal::class);
        $animalMock->shouldReceive('vaccinations')->andReturn($vaccinationsMock);

        $this->animalRepoMock->shouldReceive('findById')->with(1)->andReturn($animalMock);

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('input')->with('vaccinations', [])->once()->andReturn([3, 5]);

        $this->service->addVaccination(1, $requestMock);

        $this->assertTrue(true);
    }



    public function test_removeVaccination_calls_detach_on_animal_vaccinations(): void
    {
        $vacMock = Mockery::mock(Vaccination::class);

        $vaccinationsMock = Mockery::mock(BelongsToMany::class);
        $vaccinationsMock->shouldReceive('detach')->once()->with($vacMock);

        $animalMock = Mockery::mock(Animal::class);
        $animalMock->shouldReceive('vaccinations')->andReturn($vaccinationsMock);

        $this->animalRepoMock->shouldReceive('findById')->with(1)->once()->andReturn($animalMock);
        $this->vacRepoMock->shouldReceive('findById')->with(2)->once()->andReturn($vacMock);

        $this->service->removeVaccination(1, 2);

        $this->assertTrue(true);
    }

}




