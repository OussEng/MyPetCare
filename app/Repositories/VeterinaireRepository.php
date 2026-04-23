<?php

namespace App\Repositories;

use App\Models\Vet;

class VeterinaireRepository
{
    public function create($data){
        return Vet::create($data);
    }


    public function findAllVets()
    {
        return Vet::all();
    }

    public function findVet($id){
        return Vet::findOrFail($id);
    }

    public function findPendingVets()
    {
        $query = Vet::whereHas('user.roles', function ($query) {
            $query->where('role', 'user')
                ->where('isReviewed', false);
        })->with('user');

        return $query->paginate(10);
    }

    public function review(Vet $vet)
    {
        $vet->update(['isReviewed' => true]);
    }

    public function findVetsWithTrashed()
    {
        $query = Vet::withTrashed()
            ->with(['user' => fn($q) => $q->withTrashed()])
            ->whereHas('user', fn($q) => $q->withTrashed()
                ->whereHas('roles', fn($q) => $q
                    ->where('role', 'veterinarian')
                    ->where('isReviewed', true)
                )
            );

        return $query->paginate(8, ['*'], 'veterinarians');
    }

    public function findTrashedVet(int $id)
    {
        return Vet::withTrashed()
            ->with(['user' => fn($q) => $q->withTrashed()])
            ->with(['rendez_vous' => fn($q) => $q->withTrashed()])
            ->findOrFail($id);
    }

    public function findActiveVets()
    {
        $query = Vet::with(['user'])
            ->whereHas('user', function ($q) {
                $q->whereHas('roles', function ($query) {
                    $query->where('role', 'veterinarian')
                        ->where('isReviewed', true);
                });
            });

        return $query->paginate(8, ['*'], 'veterinarians');
    }



    public function updateVet(Vet $vet, array $data): void
    {
        $vet->update($data);

    }

    public function updateUserInfo(Vet $vet, array $userData): void
    {
        $vet->user->update($userData);
    }

}
