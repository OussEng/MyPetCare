<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function attachRole(User $user, string $role): void
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
        $query = User::whereHas('roles', function ($q) {
            $q->whereIn('role', ['user']);
        })
            ->where(function ($q) {
                $q->whereDoesntHave('vet')
                    ->orWhereHas('vet', function ($q) {
                        $q->where('isReviewed', true);
                    });
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        return $query->paginate(10, ['*'], 'clients');
    }

    public function findClient(int $id)
    {
        return User::findOrFail($id);
    }



    public function update(User $user, array $data): void
    {
        $user->update($data);
    }

    public function findAllClientsWithTrashed() : LengthAwarePaginator
    {
        return User::withTrashed()
            ->with([
                'animals' => fn($q) => $q->withTrashed()
                    ->with(['user' => fn($q) => $q->withTrashed()]),
                'rendezvous' => fn($q) => $q->withTrashed()
                    ->with([
                        'veterinaire' => fn($q) => $q->withTrashed()
                            ->with(['user' => fn($q) => $q->withTrashed()]),
                        'animal' => fn($q) => $q->withTrashed()
                            ->with(['user' => fn($q) => $q->withTrashed()]),
                        'user' => fn($q) => $q->withTrashed(),
                    ])
            ])
            ->whereHas('roles', fn($q) => $q->where('role', 'user'))
            ->paginate(10, ['*'], 'clients');
    }

    public function findTrashedClient(int $id)
    {
        return User::withTrashed()
            ->with(['animals' => fn($q) => $q->withTrashed()])
            ->with(['rendezvous' => fn($q) => $q->withTrashed()])
            ->findOrFail($id);
    }

    /**
     * @throws \Throwable
     */
    public function delete(User $user): void
    {

        DB::transaction(function () use ($user) {

            foreach ($user->rendezvous as $rendezVous) {
                $rendezVous->delete();
            }

            foreach ($user->animals as $animal) {
                $animal->delete();
            }

            $user->delete();

        });
    }

    /**
     * @throws \Throwable
     */
    public function restore($user): void
    {

        DB::transaction(function () use ($user) {

            $user->restore();

            foreach ($user->animals as $animal) {
                $animal->restore();
            }

            foreach ($user->rendezvous as $rendezVous) {
                $rendezVous->restore();
            }

        });

    }

}
