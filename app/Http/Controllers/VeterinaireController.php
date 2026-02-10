<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use App\Services\VeterinaireService;
use Illuminate\Http\Request;

class VeterinaireController extends Controller
{

    private VeterinaireService $veterinarianService;

    /**
     * @param VeterinaireService $veterinarianService
     */
    public function __construct(VeterinaireService $veterinarianService)
    {
        $this->veterinarianService = $veterinarianService;
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
}
