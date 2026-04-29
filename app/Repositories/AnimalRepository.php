<?php

namespace App\Repositories;

use App\Models\Animal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $animal = Animal::findOrFail($id);


            $animal->vaccinations()->detach();

            $animal->rendezvous()->delete();

            $animal->delete();
        });
    }

    public function update(int $id, array $data): Animal
    {
        $animal = Animal::findOrFail($id);
        $animal->update($data);
        return $animal;
    }

}
