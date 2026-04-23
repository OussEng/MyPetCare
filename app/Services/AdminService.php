<?php

namespace App\Services;

use App\DTOs\Response\User\UserResponseDTO;
use App\DTOs\Response\Veterinaire\VeterinaireResponseDTO;
use App\Repositories\UserRepository;
use App\Repositories\VeterinaireRepository;

class AdminService
{

    private VeterinaireRepository $vetRepository;
    private UserRepository $userRepository;

    /**
     * @param VeterinaireRepository $vetRepository
     * @param UserRepository $userRepository
     */
    public function __construct(VeterinaireRepository $vetRepository, UserRepository $userRepository)
    {
        $this->vetRepository = $vetRepository;
        $this->userRepository = $userRepository;
    }


    public function acceptVet(int $id): void
    {
        $vet = $this->vetRepository->findVet($id);
        $this->userRepository->switchRole($vet->user, "veterinarian");
        $this->vetRepository->review($vet);
    }

    public function rejectVet(int $id): void
    {
        $vet = $this->vetRepository->findVet($id);
        $this->vetRepository->review($vet);
    }

    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->findClient($id);

        $this->userRepository->deleteWithRelations($user);

    }

    public function restoreUser(int $id): void
    {
        $user = $this->userRepository->findTrashedClient($id);
        $this->userRepository->restore($user);
    }

    public function deleteVet(int $id)
    {
        $vet = $this->vetRepository->findVet($id);

        $this->vetRepository->deleteWithRelations($vet);
    }

    public function restoreVet(int $id): void
    {
        $vet = $this->vetRepository->findTrashedVet($id);

        $this->vetRepository->restore($vet);
    }

    public function getClientsWithTrashed()
    {
        $users = $this->userRepository->findAllClientsWithTrashed();

        return $users->through(fn($user) => UserResponseDTO::fromModel($user));
    }

    public function getVetsWithTrashed()
    {
        $vets = $this->vetRepository->findVetsWithTrashed();


        return $vets->through(fn($vet) => VeterinaireResponseDTO::fromModel($vet));
    }


}
