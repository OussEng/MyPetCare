<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use App\Services\AnimalService;
use App\Services\EspeceService;
use App\Services\RendezVousService;
use App\Services\SexeServices;
use App\Services\UserService;
use App\Services\VeterinaireService;
use Illuminate\Http\Request;

class VeterinaireController extends Controller
{

    private VeterinaireService $veterinarianService;
    private RendezVousService $rendezVousService;

    private UserService $userService;
    private EspeceService $especeService;
    private SexeServices $sexeService;
    private AnimalService $animalService;

    /**
     * @param VeterinaireService $veterinarianService
     */
    public function __construct(VeterinaireService $veterinarianService, RendezVousService $rendezVousService, UserService $userService, EspeceService $especeService, SexeServices $sexeService, AnimalService $animalService)
    {
        $this->veterinarianService = $veterinarianService;
        $this->rendezVousService = $rendezVousService;
        $this->userService = $userService;
        $this->especeService = $especeService;
        $this->sexeService = $sexeService;
        $this->animalService = $animalService;
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
        $pending = $this->rendezVousService->getPendingAponintements();


        return view('vet.Back Office.veretinarian-backoffice',[
            'rendez_vous' => $rendez_vous,
            'pending' => $pending
        ]);

    }

    public function list_clients(Request $request)
    {



        $clients = $this->userService->getAllClients($request->input('search'));



        return view('vet.Back Office.Clients.clients-list' , [
            'clients' => $clients
        ]);

    }

    public function client_profile(int $id)
    {
        $client = $this->userService->getClient($id);
        $especes = $this->especeService->getEspeces();
        $sexes = $this->sexeService->getSexes();

        return view('vet.Back Office.Clients.client-profile' , [
            'client' => $client,
            'especes' => $especes,
            'sexes' => $sexes,
        ]);

    }

    public function list(Request $request)
    {
        $rendezVous = $this->rendezVousService->getAllApointementsByVet($request->get('etat'),$request->get('jour'));

        return view('vet.Back Office.veterinaire-rendez_vous-list' , [
            'rendezVous' => $rendezVous
        ]);

    }


}
