<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalRequest;
use App\Services\AnimalService;
use App\Services\EspeceService;
use App\Services\SexeServices;
use App\Services\VaccinationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{


    private AnimalService $animalService;
    private EspeceService $especeService;
    private SexeServices $sexeService;
    private VaccinationService $vaccinationService;

    public function __construct(AnimalService $animalService, EspeceService $especeService, SexeServices $sexeService, VaccinationService $vaccinationService)
    {
        $this->animalService = $animalService;
        $this->especeService = $especeService;
        $this->sexeService = $sexeService;
        $this->vaccinationService = $vaccinationService;

    }

    //list des animeux
    public function list()
    {
        $animals = $this->animalService->getAllanimalsByUser(Auth::id());

        return view('animal.list-animeux' ,[
            'animals' => $animals,
        ]);
    }

    //form pour creer un animal domistique
    public function form(){

        $especes = $this->especeService->getEspeces();
        $sexes = $this->sexeService->getSexes();

        return view('animal.creer-animal',[
            'especes' => $especes,
            'sexes' => $sexes,
        ]);
    }

    //sauvgarder l'animal domistique
    public function save(AnimalRequest $request){

        $this->animalService->create($request);

        return redirect()->route('animaux');

    }

    public function listAnimalVaccinations($id){

        $vaccinations = $this->vaccinationService->getVaccinationsBySpecies($id);
        $animal = $this->animalService->getAnimalById($id);

        return view('animal.list-vaccinations',[
            'vaccinations' => $vaccinations,
            'animal' => $animal,
        ]);

    }



    public function ajouter_vaccinations(int $id, Request $request){

        $this->vaccinationService->addVaccination($id, $request);

        return redirect()->route('vaccinations' , $id);
    }

    public function supprimer_vaccination(int $animal_id, int $vaccination_id){

        $this->vaccinationService->removeVaccination($animal_id, $vaccination_id);

        return redirect()->route('vaccinations' , $animal_id);
    }









}
