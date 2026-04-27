<?php

namespace App\Repositories;

use App\Models\Langue;
use Illuminate\Support\Collection;

class LangueRepository
{


    public function findAll() : Collection
    {
        return Langue::all();
    }

}
