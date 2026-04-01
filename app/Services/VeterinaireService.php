<?php

namespace App\Services;

use App\DTOs\Requests\UserRequestDTO;
use App\DTOs\Requests\VeterinaireCreateDTO;
use App\DTOs\Response\VeterinaireResponseDTO;
use App\Models\Vet;
use App\Repositories\VeterinaireRepository;
use Illuminate\Http\Request;
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



    public function getAllVets()
    {
         $vets = $this->repository->findActiveVets();


        return $vets->through(fn($vet) => VeterinaireResponseDTO::fromModel($vet) );
    }


    public function getVet(int $id) : VeterinaireResponseDTO
    {
        $vet = $this->repository->findVet($id);
        return VeterinaireResponseDTO::fromModel($vet);
    }

    public function editLangues(Request $request,int $id): void
    {

        $vet = $this->repository->findVet($id);
        $langues = $request->input("langues" , []);

        $vet->langues()->sync($langues);

    }

    public function getPendingVets()
    {
        $vets = $this->repository->findPendingVets();

        return $vets->through(fn($vet) => VeterinaireResponseDTO::fromModel($vet));
    }


}
