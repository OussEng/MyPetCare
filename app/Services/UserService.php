<?php

namespace App\Services;

use App\DTOs\RegisterUserDTO;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(RegisterUserDTO $dto,string $role,UserRepository $userRepository) : User
    {
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





}
