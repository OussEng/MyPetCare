<?php

namespace App\Repositories;

use App\Models\Sexe;
use Illuminate\Support\Collection;

class SexeRepository
{

    public function findSexes() : Collection
    {
        return Sexe::all();
    }

}
