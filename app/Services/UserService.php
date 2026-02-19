<?php

namespace App\Services;

use App\DTOs\Requests\RegisterUserDTO;
use App\DTOs\Response\UserResponseDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }



    public function register(RegisterUserDTO $dto,string $role) : User
    {
        $userRepository = $this->userRepository;

        return DB::transaction(function() use ($userRepository, $dto, $role) {
            $user = $userRepository->create([
                ...$dto->toArray(),
                'password' => Hash::make($dto->password)
            ]);

            $userRepository->attachRole($user, $role);

            ;

            return $user;
        });

    }

    public function getAllClients(string $search=null)
    {

        $query = $this->userRepository->findAllClients();


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }


        $clientsPaginated = $query->paginate(10);


        return $clientsPaginated->through(fn($client) => UserResponseDTO::fromModel($client));

    }

    public function getClient(int $id)
    {
        $client = $this->userRepository->findClient($id);

        return UserResponseDTO::fromModel($client);

    }


}
