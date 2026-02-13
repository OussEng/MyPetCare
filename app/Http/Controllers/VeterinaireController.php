<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use App\Services\RendezVousService;
use App\Services\VeterinaireService;
use Illuminate\Http\Request;

class VeterinaireController extends Controller
{

    private VeterinaireService $veterinarianService;
    private RendezVousService $rendezVousService;

    /**
     * @param VeterinaireService $veterinarianService
     */
    public function __construct(VeterinaireService $veterinarianService, RendezVousService $rendezVousService)
    {
        $this->veterinarianService = $veterinarianService;
        $this->rendezVousService = $rendezVousService;
    }


    public function list_vets()
    {
        $vets = $this->veterinarianService->getAllVets();

        return view('vet.vet-list' , [
            'vets' => $vets]);
    }

    public function vet_profile($id)
    {
        $vet = $this->veterinarianService->getVet($id);

        return view('vet.vet-profile' , [
            'vet' => $vet
        ]);

    }




    //veterinarian back office index
    public function backoffice()
    {
        $rendez_vous = $this->rendezVousService->getTodaysApointement();


        return view('vet.Back Office.veretinarian-backoffice',[
            'rendez_vous' => $rendez_vous
        ]);

    }



}
