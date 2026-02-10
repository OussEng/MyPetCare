<?php

namespace App\Repositories;

use App\Models\Animal;
use Illuminate\Support\Collection;

class AnimalRepository
{

    public function findAllbyUser($id) : Collection
    {
        return Animal::where('user_id', $id)->get();
    }

    public function findById(int $id) : Animal
    {
        return Animal::find($id);
    }

    public function create(array $data)
    {
        return Animal::create($data);
    }

}
