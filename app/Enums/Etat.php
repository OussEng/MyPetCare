<?php

namespace App\Enums;

enum Etat : string
{
    case CONFIRMER = 'confirmé';
    case TERMINER = 'terminé';
    case ANULLER = 'annulé';


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
