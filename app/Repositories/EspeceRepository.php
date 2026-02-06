<?php

namespace App\Repositories;

use App\Models\Espece;
use Illuminate\Support\Collection;

class EspeceRepository
{

    public function findAll() : Collection
    {
        return Espece::all();

    }

    public function findByname(string $name) : Espece
    {
        return Espece::where('libelle', $name)->first();
    }

}
