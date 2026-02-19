<?php

namespace App\Services;

use App\DTOs\Requests\UserRequestDTO;
use App\DTOs\Requests\VeterinaireCreateDTO;
use App\DTOs\Response\VeterinaireViewDTO;
use App\Models\Vet;
use App\Repositories\VeterinaireRepository;
use Illuminate\Support\Collection;

class VeterinaireService
{

        private VeterinaireRepository $repository;
        public function __construct(VeterinaireRepository $repository){
            $this->repository = $repository;
        }



    public function createVeterinarian(VeterinaireCreateDTO $dto, int $user_id, VeterinaireRepository $repository): Vet
    {
        $data = $dto->toArray();
        $data['user_id'] = $user_id;

        return $repository->create($data);

    }



    public function getAllVets() : Collection
    {
         $vets = $this->repository->findAllVets();


        return $vets->map(fn($vet) => VeterinaireViewDTO::fromModel($vet) );
    }


    public function getVet(int $id) : VeterinaireViewDTO
    {
        $vet = $this->repository->findVet($id);

        return VeterinaireViewDTO::fromModel($vet);
    }


}
