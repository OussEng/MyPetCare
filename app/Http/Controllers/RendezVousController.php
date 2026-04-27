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
    private RendezVousService $rendezVousService;


    public function __construct(RendezVousService $rendezVousService)
    {
        $this->rendezVousService = $rendezVousService;
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

    return redirect('/mes-rendez-vous')->with('success', 'Rendez-vous réservé avec succès');
    }


    public function list(Request $request){

        $rendezvous = $this->rendezVousService->getRendezVousByUser($request);

        return view('animal.mes-rendez-vous', [
            'rendezvous' => $rendezvous,
        ]);
    }

    public function cancel(int $id)
    {
        $cancelled = $this->rendezVousService->cancel($id, Auth::id());

        if (!$cancelled) {
            return redirect()->route('rendez-vous.list')->with('error', 'Impossible d\'annuler ce rendez-vous.');
        }

        return redirect()->route('rendez-vous.list')->with('success', 'Rendez-vous annulé avec succès.');
    }

}
