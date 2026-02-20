<?php

namespace App\Repositories;

use App\Enums\Etat;
use App\Models\RendezVous;
use Carbon\CarbonImmutable;

use Illuminate\Support\Collection;

class RendezVousRepository
{

    public function findAllByVet(int $id)
    {
        $today = CarbonImmutable::today();

        return RendezVous::where('veterinaire_id', $id)
            ->orderByRaw("
            CASE
                WHEN DATE(\"dateHeureDebut\") = ? THEN 1
                WHEN \"dateHeureDebut\" > ? THEN 2
                ELSE 3
            END ASC, \"dateHeureDebut\" ASC
        ", [$today, $today]);
    }

    public function findAllByUser(int $id) : Collection
    {
        return RendezVous::where('user_id' , $id)->get();
    }

    public function create(array $data) : RendezVous
    {
        return RendezVous::create($data);

    }

    public function findPending()
    {
        return RendezVous::where('etat', Etat::EN_ATTENT)->get();
    }

    public function findTodayApointement() : Collection
    {
        return RendezVous::whereIn('etat',[Etat::CONFIRMER,Etat::EN_ATTENT ] )
            ->whereDate('dateHeureDebut', '=', CarbonImmutable::today())->get();

    }


}
