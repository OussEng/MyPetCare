<?php

namespace App\Services;

use App\DTOs\VeterinarianDTO;
use App\Models\User;
use App\Models\Vet;
use App\Repositories\VeterinarianRepository;

class VeterinarianService
{

    public function createVeterinarian(VeterinarianDTO $dto, int $user_id,VeterinarianRepository $repository): Vet
    {
        $data = $dto->toArray();
        $data['user_id'] = $user_id;

        return $repository->create($data);

    }

}
