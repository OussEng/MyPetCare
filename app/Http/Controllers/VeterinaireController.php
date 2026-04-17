<?php

namespace App\Http\Controllers;

use App\DTOs\Requests\UpdateUserDTO;
use App\DTOs\Requests\VeterinaireUpdateDTO;
use App\Http\Requests\VetProfileUpdateRequest;
use App\Services\AnimalService;
use App\Services\EspeceService;
use App\Services\LangueService;
use App\Services\RendezVousService;
use App\Services\SexeServices;
use App\Services\UserService;
use App\Services\VeterinaireService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VeterinaireController extends Controller
{

    private VeterinaireService $veterinarianService;
    private RendezVousService $rendezVousService;

    private UserService $userService;
    private EspeceService $especeService;
    private SexeServices $sexeService;
    private AnimalService $animalService;
    private LangueService $langueService;

    /**
     * @param VeterinaireService $veterinarianService
     */
    public function __construct(VeterinaireService $veterinarianService, RendezVousService $rendezVousService, UserService $userService, EspeceService $especeService, SexeServices $sexeService, AnimalService $animalService, LangueService $langueService)
    {
        $this->veterinarianService = $veterinarianService;
        $this->rendezVousService = $rendezVousService;
        $this->userService = $userService;
        $this->especeService = $especeService;
        $this->sexeService = $sexeService;
        $this->animalService = $animalService;
        $this->langueService = $langueService;
    }


    public function list_vets()
    {
        $vets = $this->veterinarianService->getAllVets();

        return view('vet.vet-list' , [
            'vets' => $vets]);
    }

    //profile that clients see
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
        $appointments = $this->rendezVousService->getCurrentAndNextAppointments();

        return view('vet.Back Office.veretinarian-backoffice', [
            'current_appointment' => $appointments['current'],
            'next_appointment'    => $appointments['next'],
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
        return view('vet.Back Office.Clients.client-profile', [
            'client'  => $this->userService->getClient($id),
            'especes' => $this->especeService->getEspeces(),
            'sexes'   => $this->sexeService->getSexes(),
        ]);
    }

    public function list(Request $request)
    {
        $rendezVous = $this->rendezVousService->getAllApointementsByVet(
            $request->get('etat'),
            $request->get('jour')
        );

        return view('vet.Back Office.veterinaire-rendez_vous-list', ['rendezVous' => $rendezVous]);
    }

    public function cancel(int $id): RedirectResponse
    {
        $cancelled = $this->rendezVousService->cancelByVet($id, Auth::user()->vet->id);

        if (!$cancelled) {
            return redirect()->route('vet.rendez-vous.list')->with('error', 'Impossible d\'annuler ce rendez-vous.');
        }

        return redirect()->route('vet.rendez-vous.list')->with('success', 'Rendez-vous annulé avec succès.');
    }

    public function profile()
    {
        return view('vet.Back Office.veterinaire-profile', [
            'vet'     => $this->veterinarianService->getVet(Auth::user()->vet->id),
            'langues' => $this->langueService->getLangues(),
        ]);
    }

    public function editLangues(Request $request): RedirectResponse
    {
        $this->veterinarianService->editLangues($request, Auth::user()->vet->id);

        return redirect()->back()->with('success', 'Langues mises à jour avec succès.');
    }

    public function updateProfile(VetProfileUpdateRequest $request): RedirectResponse
    {
        $this->veterinarianService->updateProfile(
            VeterinaireUpdateDTO::fromRequest($request),
            UpdateUserDTO::fromRequest($request),
        );

        return redirect()->route('veterinaire.profile')->with('success', 'Profil mis à jour avec succès.');
    }

}
