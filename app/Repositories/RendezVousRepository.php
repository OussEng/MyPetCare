<?php

namespace App\Repositories;

use App\Models\RendezVous;
use Illuminate\Support\Collection;

class RendezVousRepository
{

    public function findAllByVet(int $id) : Collection
    {
        return RendezVous::where('veterinaire_id' , $id)->get();
    }

    public function findAllByUser(int $id) : Collection
    {
        return RendezVous::where('user_id' , $id)->get();
    }

    public function create(array $data) : RendezVous
    {
        return RendezVous::create($data);

    }





}
