<?php

namespace App\Http\Controllers;


use App\Services\AdminService;
use App\Services\VeterinaireService;

class AdminController
{

    private AdminService  $adminService;
    private VeterinaireService $veterinaireService;

    public function __construct(VeterinaireService $veterinaireService, AdminService $adminService)
    {
        $this->veterinaireService = $veterinaireService;
        $this->adminService = $adminService;
    }

    public function backoffice(){
        return view('admin.backoffice');
    }


    public function pendingVets()
    {
        $vets = $this->veterinaireService->getPendingVets();

        return view('admin.vet.list-vet',[
            'vets' => $vets
        ]);
    }

    public function vetDetail($id)
    {
        $vet = $this->veterinaireService->getVet($id);

        return view('admin.vet.detail-vet',[
            'vet' => $vet
        ]);
    }

    public function vetAccept(int $id)
    {
        $this->adminService->acceptVet($id);

        return redirect()->route('admin.pending-vets')->with('success','Vétérinaire accepté avec succès.');
    }

    public function vetReject(int $id)
    {
        $this->adminService->rejectVet($id);

        return redirect()->route('admin.pending-vets')->with('success','Vétérinaire refusé avec succès.');
    }
}
