<?php

namespace App\Http\Controllers;


use App\Services\AdminService;
use App\Services\UserService;
use App\Services\VeterinaireService;

class AdminController
{

    private AdminService  $adminService;
    private VeterinaireService $veterinaireService;
    private UserService $userService;

    public function __construct(VeterinaireService $veterinaireService, AdminService $adminService, UserService $userService)
    {
        $this->veterinaireService = $veterinaireService;
        $this->adminService = $adminService;
        $this->userService = $userService;
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

    public function users()
    {
        $vets = $this->adminService->getVetsWithTrashed();
        $clients = $this->adminService->getClientsWithTrashed();

        return view('admin.users.list-user',[
            'vets' => $vets,
            'clients' => $clients
        ]);
    }

    public function deleteUser(int $id)
    {
        $this->adminService->deleteUser($id);

        return redirect()->route('admin.users')->with('success','Utilisateur désactivé avec succès.');
    }

    public function restoreUser(int $id)
    {
        $this->adminService->restoreUser($id);

        return redirect()->route('admin.users')->with('success','Utilisateur réactivé avec succès.');
    }

    public function deleteVet(int $id)
    {
        $this->adminService->deleteVet($id);

        return redirect()->route('admin.users')->with('success','Vétérinaire réactivé avec succès.');
    }

    public function restoreVet(int $id)
    {
         $this->adminService->restoreVet($id);

         return redirect()->route('admin.users')->with('success','Vétérinaire réactivé avec succès.');
    }


}
