<?php

namespace App\Services;

use App\DTOs\Requests\UserDTO;
use App\DTOs\Requests\VeterinarianCreateDTO;
use App\DTOs\Response\VeterinarianViewDTO;
use App\Models\Vet;
use App\Repositories\VeterinarianRepository;
use Illuminate\Support\Collection;

class VeterinarianService
{

        private VeterinarianRepository $repository;
        public function __construct(VeterinarianRepository $repository){
            $this->repository = $repository;
        }



    public function createVeterinarian(VeterinarianCreateDTO $dto, int $user_id, VeterinarianRepository $repository): Vet
    {
        $data = $dto->toArray();
        $data['user_id'] = $user_id;

        return $repository->create($data);

    }



    public function getAllVets() : Collection
    {
         $vets = $this->repository->findAllVets();


        return $vets->map(fn($vet) => VeterinarianViewDTO::fromModel($vet) );
    }


    public function getVet(int $id) : VeterinarianViewDTO
    {
        $vet = $this->repository->findVet($id);

        return VeterinarianViewDTO::fromModel($vet);
    }
}
