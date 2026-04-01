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
        return Animal::findOrFail($id);
    }

    public function create(array $data)
    {
        return Animal::create($data);
    }

    public function delete(int $id)
    {
        Animal::destroy($id);
    }

    public function update(int $id, array $data): Animal
    {
        $animal = Animal::findOrFail($id);
        $animal->update($data);
        return $animal;
    }

}
