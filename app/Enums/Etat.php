<?php

namespace App\Enums;

enum Etat : string
{
    case EN_ATTENT = 'en attente';
    case CONFIRMER = 'confirmé';
    case TERMINER = 'terminé';
    case ANULLER = 'annulé';

    public function isPending()
    {
        return $this === self::EN_ATTENT;
    }

    public function isConfirmed(){
        return $this === self::CONFIRMER;
    }
    public function isFinished(){
        return $this === self::TERMINER;
    }

    public function isCancelled(){
        return $this === self::ANULLER;
    }

}
