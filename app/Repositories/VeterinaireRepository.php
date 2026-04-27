<?php

namespace App\Repositories;

use App\Models\Vet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VeterinaireRepository
{
    public function create($data){
        return Vet::create($data);
    }


    public function findAllVets() : Collection
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

    public function review(Vet $vet): void
    {
        $vet->update(['isReviewed' => true]);
    }

    public function findVetsWithTrashed() : LengthAwarePaginator
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

    public function findActiveVets(): LengthAwarePaginator
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

    /**
     * @throws \Throwable
     */
    public function delete($vet): void
    {

        DB::transaction( function () use ($vet) {

            foreach ($vet->rendez_vous as $rendezVous) {
                $rendezVous->delete();
            }

            $vet->delete();
            $vet->user->delete();

        });
    }

    /**
     * @throws \Throwable
     */
    public function restore($vet): void
    {

        DB::transaction( function () use ($vet) {
            $vet->user->restore();
            $vet->restore();

            foreach ($vet->rendez_vous as $rendezVous) {
                $rendezVous->restore();
            }
        });


    }

}
