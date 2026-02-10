<?php

namespace App\Repositories;

use App\Models\Vet;

class VeterinaireRepository
{
    public function create($data){
        return Vet::create($data);
    }


    public function findAllVets()
    {
        return Vet::all();
    }

    public function findVet($id){
        return Vet::find($id);
    }

}
