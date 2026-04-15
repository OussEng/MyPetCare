<?php

namespace App\Services;

use App\DTOs\Requests\RegisterUserDTO;
use App\DTOs\Requests\UpdateUserDTO;
use App\DTOs\Response\UserResponseDTO;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserDTO $dto): User
    {
        $userRepository = $this->userRepository;

        return DB::transaction(function() use ($userRepository, $dto) {
            $role = 'user';
            $user = $userRepository->create([
                ...$dto->toArray(),
                'password' => Hash::make($dto->password),
            ]);

            $userRepository->attachRole($user, $role);

            return $user;
        });
    }

    public function updateProfile(User $user, UpdateUserDTO $dto): void
    {
        $data = $dto->toArray();

        if ($user->email !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        $this->userRepository->update($user, $data);
    }

    public function updatePassword(User $user, string $newPassword): void
    {
        $this->userRepository->update($user, [
            'password' => Hash::make($newPassword),
        ]);
    }

    public function getAllClients(string $search = null)
    {
        $clientsPaginated = $this->userRepository->findAllClients($search);

        return $clientsPaginated->through(fn($client) => UserResponseDTO::fromModel($client));
    }

    public function getClient(int $id)
    {
        $client = $this->userRepository->findClient($id);

        return UserResponseDTO::fromModel($client);
    }
}


