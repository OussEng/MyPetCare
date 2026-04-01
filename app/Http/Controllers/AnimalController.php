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

        if (Auth::user()->isVet()){
            return redirect()->route('veterinaire.client', ['client' => $request->user_id])->with('success', 'Animal créé avec succès');
        }

        return redirect()->route('animaux')->with('success', 'Animal créé avec succès');

    }

    public function listAnimalVaccinations($id){

        $vaccinations = $this->vaccinationService->getVaccinationsBySpecies($id);
        $animal = $this->animalService->getAnimalById($id);

        if (Auth::user()->isVet()){
            return view('vet.Back Office.Clients.client-animal-vaccination',[
                'animal' => $animal,
                'vaccinations' => $vaccinations,
            ]);
        }

        return view('animal.list-vaccinations',[
            'vaccinations' => $vaccinations,
            'animal' => $animal,
        ]);

    }


    public function delete(int $id)
    {
        $client = $this->animalService->getAnimalById($id)->user->id;
        $this->animalService->deleteAnimal($id);


        if (Auth::user()->isVet()){
            return redirect()->route('veterinaire.client', ['client' =>  $client])->with('success','Animal supprimé avec succès');
        }

        return redirect()->route('animaux')->with('success', 'Animal supprimé avec succès');
    }

    public function edit(int $id)
    {
        $animal  = $this->animalService->getAnimalById($id);
        $especes = $this->especeService->getEspeces();
        $sexes   = $this->sexeService->getSexes();

        return view('animal.modifier-animal', [
            'animal'  => $animal,
            'especes' => $especes,
            'sexes'   => $sexes,
        ]);
    }

    public function update(int $id, AnimalRequest $request)
    {
        $this->animalService->updateAnimal($id, $request);

        if (Auth::user()->isVet()) {
            $client = $this->animalService->getAnimalById($id)->user->id;
            return redirect()->route('veterinaire.client', ['client' => $client])->with('success', 'Animal modifié avec succès');
        }

        return redirect()->route('animaux')->with('success', 'Animal modifié avec succès');
    }



    public function ajouter_vaccinations(int $id, Request $request){

        $this->vaccinationService->addVaccination($id, $request);

        return redirect()->route('vaccinations' , $id)->with('success', 'Vaccination ajoutée avec succès');
    }

    public function supprimer_vaccination(int $animal_id, int $vaccination_id){

        $this->vaccinationService->removeVaccination($animal_id, $vaccination_id);

        return redirect()->route('vaccinations' , $animal_id)->with('success', 'Vaccination retirée avec succès');
    }









}
