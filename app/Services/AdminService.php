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

        foreach ($user->rendezvous as $rendezVous) {
            $rendezVous->delete();
        }

        foreach ($user->animals as $animal) {
            $animal->delete();
        }

        $user->delete();

    }

    public function restoreUser(int $id): void
    {
        $user = $this->userRepository->findTrashedClient($id);
        $user->restore();

        foreach ($user->animals as $animal) {
            $animal->restore();
        }

        foreach ($user->rendezvous as $rendezVous) {
            $rendezVous->restore();
        }

    }

    public function deleteVet(int $id)
    {
        $vet = $this->vetRepository->findVet($id);

        foreach ($vet->rendez_vous as $rendezVous) {
            $rendezVous->delete();
        }

        $vet->delete();
        $vet->user->delete();
    }

    public function restoreVet(int $id): void
    {
        $vet = $this->vetRepository->findTrashedVet($id);
        $vet->user->restore();
        $vet->restore();

        foreach ($vet->rendez_vous as $rendezVous) {
            $rendezVous->restore();
        }
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
