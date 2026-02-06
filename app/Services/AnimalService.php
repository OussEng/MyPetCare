<?php

namespace App\Services;

use App\DTOs\Requests\AnimalRequestDTO;
use App\DTOs\Response\AnimalResponseDTO;
use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use App\Repositories\AnimalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


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

        return AnimalResponseDTO::fromModel($animal);

    }







}
