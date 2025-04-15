<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Espece;
use App\Models\Sexe;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    //list des animeux
    public function list()
    {
        $animals = Animal::where('user_id', Auth::id())->get();

        return view('animal.list-animeux' ,[
            'animals' => $animals,
        ]);
    }

    //form pour creer un animal domistique
    public function form(){

        $especes = Espece::all();
        $sexes = Sexe::all();
        $vaccinations = Vaccination::all();



        return view('animal.creer-animal',[
            'especes' => $especes,
            'sexes' => $sexes,
            'vaccinations' => $vaccinations
        ]);
    }

    //sauvgarder l'animal domistique
    public function save(Request $request){

        $validated = $request->validate([
            'nom' => 'required',
            'espece' => 'required',
            'sexe' => 'required',
            'race' => 'max:255',
            'dateNaissance' => 'required',
            'poids' => 'required',
        ]);

        $animal = new Animal();
        $animal->nom = $request->input("nom");
        $animal->espece_id = $request->input("espece");
        $animal->race  = $request->input("race");
        $animal->dateNaissance = $request->input("dateNaissance");
        $animal->poids = $request->input("poids");
        $animal-> sexe_id = $request->input("sexe");
        $animal->user_id = Auth::id();



        $animal->save();

        return redirect()->route('animaux');

    }

    public function list_vaccinations($id){

        $animal = Animal::find($id);
        $vaccinations = $animal->vaccinations;


        return view('animal.list-vaccinations',[
            'vaccinations' => $vaccinations,
        ]);

    }



}
