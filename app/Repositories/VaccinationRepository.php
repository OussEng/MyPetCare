<?php

namespace App\Repositories;

use App\Models\Vaccination;
use Illuminate\Support\Collection;

class VaccinationRepository
{

    public function findAll() : Collection
    {
        return Vaccination::all();
    }


    public function findById(int $id) : Vaccination
    {
        return Vaccination::findOrFail($id);
    }

}
