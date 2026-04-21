<?php

namespace App\Repositories;

use App\Models\Langue;

class LangueRepository
{


    public function findAll()
    {
        return Langue::all();
    }

}
