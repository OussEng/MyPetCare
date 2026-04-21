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

    public function findAllByUser(int $id, ?Etat $etat = null, bool $today = false)
    {
        $query = RendezVous::where('user_id', $id)
            ->orderByRaw("
                CASE
                    WHEN DATE(\"dateHeureDebut\") = ? THEN 1
                    WHEN \"dateHeureDebut\" > ? THEN 2
                    ELSE 3
                END ASC, \"dateHeureDebut\" ASC
            ", [CarbonImmutable::today(), CarbonImmutable::today()]);

        if ($etat) {
            $query->where('etat', $etat->value);
        }

        if ($today) {
            $query->whereDate('dateHeureDebut', '=', CarbonImmutable::today())
                  ->where('etat', Etat::CONFIRMER);
        }

        return $query->paginate(10);
    }

    public function create(array $data) : RendezVous
    {
        return RendezVous::create($data);
    }

    public function findPending()
    {
        return RendezVous::where('etat', Etat::CONFIRMER)->get();
    }

    public function findTodayApointement() : Collection
    {
        return RendezVous::where('etat', Etat::CONFIRMER)
            ->whereDate('dateHeureDebut', '=', CarbonImmutable::today())->get();
    }

    public function findCurrentAppointment(int $vetId) : ?RendezVous
    {
        $now = CarbonImmutable::now();

        return RendezVous::where('etat', Etat::CONFIRMER)
            ->where('veterinaire_id', $vetId)
            ->where('dateHeureDebut', '<=', $now)
            ->where('dateHeureDebut', '>=', $now->subHour())
            ->orderBy('dateHeureDebut', 'desc')
            ->first();
    }

    public function findNextAppointment(int $vetId) : ?RendezVous
    {
        return RendezVous::where('etat', Etat::CONFIRMER)
            ->where('veterinaire_id', $vetId)
            ->where('dateHeureDebut', '>', CarbonImmutable::now())
            ->orderBy('dateHeureDebut', 'asc')
            ->first();
    }

    public function cancel(int $id, int $userId) : bool
    {
        $rendezVous = RendezVous::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$rendezVous) {
            return false;
        }

        $rendezVous->etat = Etat::ANULLER;
        return $rendezVous->save();
    }

    public function cancelByVet(int $id, int $vetId) : bool
    {
        $rendezVous = RendezVous::where('id', $id)
            ->where('veterinaire_id', $vetId)
            ->first();

        if (!$rendezVous) {
            return false;
        }

        $rendezVous->etat = Etat::ANULLER;
        return $rendezVous->save();
    }

    public function save(RendezVous $rv): void
    {
        $rv->save();
    }
}
