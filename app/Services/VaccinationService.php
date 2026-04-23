<?php

namespace App\Services;

use App\DTOs\Response\Vaccination\VaccinationResponseDTO;
use App\Repositories\AnimalRepository;
use App\Repositories\VaccinationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VaccinationService
{
    private VaccinationRepository $vaccinationRepository;
    private AnimalService $animalService;
    private EspeceService $especeService;
    private AnimalRepository $animalRepository;

    public function __construct(VaccinationRepository $vaccinationRepository, AnimalService $animalService, EspeceService $especeService, AnimalRepository $animalRepository)
    {
        $this->vaccinationRepository = $vaccinationRepository;
        $this->animalService = $animalService;
        $this->especeService = $especeService;
        $this->animalRepository = $animalRepository;
    }


    public function getVaccinations() : Collection
    {
        $vaccinations = $this->vaccinationRepository->findAll();

        return $vaccinations->map(fn ($vaccination) => VaccinationResponseDTO::fromModel($vaccination));

    }



    public function getVaccinationsBySpecies(int $id) : Collection
    {
        $animal = $this->animalService->getAnimalById($id);

        return $animal->espece->vaccinations;
    }

    public function addVaccination(int $id, Request $request) : Void
    {
        $animal = $this->animalRepository->findById($id);
        $vaccinations = $request->input("vaccinations" , []);
        $animal->vaccinations()->syncWithoutDetaching($vaccinations);
    }

    public function removeVaccination(int $animal_id, int $vaccination_id ) : void
    {
        $animal = $this->animalRepository->findById($animal_id);
        $vaccination = $this->vaccinationRepository->findById($vaccination_id);
        $animal->vaccinations()->detach($vaccination);

    }

}
