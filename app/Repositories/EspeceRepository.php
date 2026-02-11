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


}
