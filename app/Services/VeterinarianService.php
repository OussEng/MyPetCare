<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\DTOs\VeterinarianCreateDTO;
use App\DTOs\VeterinarianViewDTO;
use App\Models\User;
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



        $vetsDTO = $vets->map(fn($vet) => new VeterinarianViewDTO(
            $vet->id,
            new UserDTO(
                $vet->user->id,
                $vet->user->prenom,
                $vet->user->nom,
                $vet->user->email,
                $vet->user->numero,
                $vet->user->adresse
            ),
            $vet->numeroLicence,
            $vet->nomClinique,
            $vet->NbAnsExperience,
            $vet->dateDeNaissance,
            $vet->licenceExpiration,
            $vet->horaires,
            $vet->certification,
            $vet->user_id,
            $vet->created_at,
            $vet->updated_at
        ));

        return $vetsDTO;
    }

    public function getVet(int $id) : VeterinarianViewDTO
    {
        $vet = $this->repository->findVet($id);

        $vetsDTO = new VeterinarianViewDTO(
                $vet->id,
                new UserDTO(
                    $vet->user->id,
                    $vet->user->prenom,
                    $vet->user->nom,
                    $vet->user->email,
                    $vet->user->numero,
                    $vet->user->adresse
                ),
                $vet->numeroLicence,
                $vet->nomClinique,
                $vet->NbAnsExperience,
                $vet->dateDeNaissance,
                $vet->licenceExpiration,
                $vet->horaires,
                $vet->certification,
                $vet->user_id,
                $vet->created_at,
                $vet->updated_at
            );



        return $vetsDTO;
    }
}
