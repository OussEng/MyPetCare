<?php

namespace App\Managers;

use App\Enums\Etat;
use App\Repositories\RendezVousRepository;
use DateTimeImmutable;

class RendezVousManager
{

    private RendezVousRepository $rendezVousRepository;

    public function __construct(RendezVousRepository $rendezVousRepository){
        $this->rendezVousRepository = $rendezVousRepository;
    }

    public function handleState(): void
    {
        $rvs = $this->rendezVousRepository->findPending();
        $now = new DateTimeImmutable();

        foreach ($rvs as $rv) {
            $debut = $rv->dateHeureDebut;
            $fin = $debut->modify('+1 hour');

            if ($now > $fin) {
                $rv->etat = Etat::TERMINER;
                $this->rendezVousRepository->save($rv);
            }
        }
    }


}
