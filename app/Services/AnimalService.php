<?php

namespace App\Services;

use App\DTOs\Requests\Animal\AnimalRequestDTO;
use App\DTOs\Response\Animal\AnimalResponseDTO;
use App\Http\Requests\AnimalRequest;
use App\Http\Requests\AnimalUpdateRequest;
use App\Models\Animal;
use App\Repositories\AnimalRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;


class AnimalService
{
    private AnimalRepository $repository;



    public function __construct(AnimalRepository $repository){
        $this->repository = $repository;

    }




    public function create(AnimalRequest $request): Animal
    {
        $dto = AnimalRequestDTO::fromRequest($request);

        $data = $dto -> toArray();

        return $this->repository->create($data);
    }






    public function getAllanimalsByUser($id) : Collection
    {
        $animals = $this->repository->findAllbyUser($id);

        return $animals->map(fn(Animal $animal) => AnimalResponseDTO::fromModel($animal));
    }



    public function getAnimalById(int $id) : AnimalResponseDTO
    {

        $animal = $this->repository->findById($id);
        Gate::authorize('view', $animal );
        return AnimalResponseDTO::fromModel($animal);

    }

    public function deleteAnimal(int $id): void
    {
        $animal = $this->repository->findById($id);

        Gate::authorize('delete', $animal);

        $this->repository->delete($id);
    }

    public function updateAnimal(int $id, AnimalUpdateRequest $request): Animal
    {
        $animal = $this->repository->findById($id);

        Gate::authorize('update', $animal);

        $data = $request->validated();

        return $this->repository->update($id, $data);
    }

}
