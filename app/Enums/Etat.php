<?php

namespace App\Enums;

enum Etat : string
{
    case CONFIRMER = 'confirmé';
    case TERMINER = 'terminé';
    case ANULLER = 'annulé';


    public function isConfirmed(): bool
    {
        return $this === self::CONFIRMER;
    }
    public function isFinished(): bool
    {
        return $this === self::TERMINER;
    }

    public function isCancelled(): bool
    {
        return $this === self::ANULLER;
    }

}
