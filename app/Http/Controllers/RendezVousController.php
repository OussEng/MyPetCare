<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vet;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{

    public function list_vets()
    {
        $vets = Vet::all();

        return view('vet.vet-list' , [
            'vets' => $vets]);
    }

    public function vet_profile($id)
    {
        $vet = Vet::find($id);

        return view('vet.vet-profile' , [
            'vet' => $vet
        ]);

    }

}
