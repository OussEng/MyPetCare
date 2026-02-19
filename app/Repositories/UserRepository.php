<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function attachRole(User $user, string $role)
    {
    $role = Role::where('role', $role)->firstOrFail();
    $user -> roles() ->attach($role);
    }

    public function findAllClients()
    {
        return User::doesntHave('vet');
    }

    public function findClient(int $id)
    {
        return User::find($id);
    }

}
