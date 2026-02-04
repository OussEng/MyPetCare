<?php

namespace App\Repositories;

use App\Models\Vet;

class VeterinarianRepository
{
    public function create($data){
        return Vet::create($data);
    }

}
