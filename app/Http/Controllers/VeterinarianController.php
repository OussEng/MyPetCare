<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use App\Services\VeterinarianService;
use Illuminate\Http\Request;

class VeterinarianController extends Controller
{

    private VeterinarianService $veterinarianService;

    /**
     * @param VeterinarianService $veterinarianService
     */
    public function __construct(VeterinarianService $veterinarianService)
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
