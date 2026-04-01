<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\VeterinaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mes-animaux', [AnimalController::class, 'list'])->name('animaux');

    //Creation des animaux
    Route::get('/creer-animal', [AnimalController::class, 'form'])->name('animaux.form');
    Route::post('/creer-animal', [AnimalController::class, 'save'])->name('animaux.save');
    Route::delete('animals/{animal}/delete', [AnimalController::class, 'delete'])->name('animaux.delete');

    //Vaccination
    Route::get('/vaccinations/{id}', [AnimalController::class, 'listAnimalVaccinations'])->name('vaccinations');

    //Vet
        //vet list
    Route::get('/rendez-vous', [VeterinaireController::class, 'list_vets'])->name('list.vets');
        //Vet profile
    Route::get('/veterinaires/{id}', [VeterinaireController::class, 'vet_profile'])->name('vet.profile');

    //Appointment
        //prendre rendez-vous
    Route::get('/rendez/{id}', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::post('/rendez/{id}', [RendezVousController::class, 'save'])->name('rendez-vous.store');


        //Rendez-vous pris
    Route::get('mes-rendez-vous', [RendezVousController::class, 'list'])->name('rendez-vous.list');

});


Route::middleware(['auth', 'veterinaire'])->group(function () {

    Route::get('/vet/backoffice', [VeterinaireController::class, 'backoffice'])->name('veterinaire.backoffice');

    //clients list
    Route::get('vet/backoffice/clients', [VeterinaireController::class, 'list_clients'])->name('veterinaire.clients');

    //consulter un client
    Route::get('vet/backoffice/client/{client}', [VeterinaireController::class, 'client_profile'])->name('veterinaire.client');

    //veterinaire rendez vous list
    Route::get('vet/backoffice/mes-rendez-vous', [VeterinaireController::class, 'list'])->name('vet.rendez-vous.list');

    Route::get('vet/backoffice/profile' , [VeterinaireController::class, 'profile'])->name('veterinaire.profile');

    Route::post('vet/backoffice/profile',[VeterinaireController::class, 'editLangues'])->name('veterinaire.add-langues');

    Route::post('/vaccinations/{id}', [AnimalController::class, 'ajouter_vaccinations'])->name('vaccinations.add');
    Route::post('/animals/{animal_id}/vaccinations/{vaccination_id}/remove', [AnimalController::class, 'supprimer_vaccination'])->name('vaccination.remove');



});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/backoffice', [AdminController::class, 'backoffice'])->name('admin.backoffice');
    Route::get("/admin/pending-vets", [AdminController::class, 'pendingVets'])->name('admin.pending-vets');
    Route::get("/admin/vet/{id}", [AdminController::class, 'vetDetail'])->name('admin.vet.detail');

    Route::post('/admin/vet/accept/{id}', [AdminController::class, 'vetAccept'])->name('admin.vet.accept');
    Route::post('/admin/vet/reject/{id}', [AdminController::class, 'vetReject'])->name('admin.vet.reject');
});



require __DIR__.'/auth.php';
