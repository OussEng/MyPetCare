<?php

namespace App\Services;

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
}
