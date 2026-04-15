<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;

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

    public function switchRole(User $user, string $role): void
    {
        $role = Role::where('role', $role)->firstOrFail();

        $user->roles()->sync([$role->id]);
    }



    public function findAllClients(string $search = null)
    {
        $query = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('role', ['veterinarian', 'admin']);
        });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10);
    }

    public function findClient(int $id)
    {
        return User::findOrFail($id);
    }

    public function update(User $user, array $data): void
    {
        $user->update($data);
    }

}
