<?php

namespace App\Http\Controllers;

use App\Http\Requests\RendezVousRequest;
use App\Models\Animal;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Vet;
use App\Services\AnimalService;
use App\Services\RendezVousService;
use App\Services\VeterinaireService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    private VeterinaireService $veterinarianService;
    private RendezVousService $rendezVousService;
    private AnimalService $animalService;


    public function __construct(VeterinaireService $veterinarianService, RendezVousService $rendezVousService, AnimalService $animalService)
    {
        $this->veterinarianService = $veterinarianService;
        $this->rendezVousService = $rendezVousService;
        $this->animalService = $animalService;
    }


    public function index(Request $request,int $id)
    {
        $ApointementData = $this->rendezVousService->getAvailableSlotsForVet($id, Auth::id(),$request->input('date'));

        return view('rendez-vous.rendez-vous', [
            'data' => $ApointementData,
        ]);
    }



    public function save(RendezVousRequest $request){

            $this->rendezVousService->create($request);

        return redirect('/rendez-vous');

    }


    public function list(){

        $rendezvous = $this->rendezVousService->getRendezVousByUser(Auth::id());


        return view('animal.mes-rendez-vous' , [
            'rendezvous' => $rendezvous
        ]);
    }

}
