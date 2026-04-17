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
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mes-animaux', [AnimalController::class, 'list'])->name('animaux');

    //Creation des animaux
    Route::get('/creer-animal', [AnimalController::class, 'form'])->name('animaux.form');
    Route::post('/creer-animal', [AnimalController::class, 'save'])->name('animaux.save');
    Route::delete('animals/{animal}/delete', [AnimalController::class, 'delete'])->name('animaux.delete');
    Route::get('animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animaux.edit');
    Route::put('animals/{animal}/update', [AnimalController::class, 'update'])->name('animaux.update');

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

    //Annuler un rendez-vous
    Route::patch('mes-rendez-vous/{id}/cancel', [RendezVousController::class, 'cancel'])->name('rendez-vous.cancel');

});



Route::middleware(['auth', 'veterinaire', 'desktop.only'])->group(function () {
    Route::get('/vet/backoffice', [VeterinaireController::class, 'backoffice'])->name('veterinaire.backoffice');

    //clients list
    Route::get('vet/backoffice/clients', [VeterinaireController::class, 'list_clients'])->name('veterinaire.clients');

    //consulter un client
    Route::get('vet/backoffice/client/{client}', [VeterinaireController::class, 'client_profile'])->name('veterinaire.client');

    //veterinaire rendez vous list
    Route::get('vet/backoffice/mes-rendez-vous', [VeterinaireController::class, 'list'])->name('vet.rendez-vous.list');

    //Annuler un rendez-vous (vet)
    Route::patch('vet/backoffice/mes-rendez-vous/{id}/cancel', [VeterinaireController::class, 'cancel'])->name('vet.rendez-vous.cancel');

    Route::get('vet/backoffice/profile' , [VeterinaireController::class, 'profile'])->name('veterinaire.profile');

    Route::post('vet/backoffice/profile',[VeterinaireController::class, 'editLangues'])->name('veterinaire.add-langues');

    Route::put('vet/backoffice/profile',[VeterinaireController::class, 'updateProfile'])->name('veterinaire.profile.update');

    Route::post('/vaccinations/{id}', [AnimalController::class, 'ajouter_vaccinations'])->name('vaccinations.add');
    Route::post('/animals/{animal_id}/vaccinations/{vaccination_id}/remove', [AnimalController::class, 'supprimer_vaccination'])->name('vaccination.remove');



});

Route::middleware(['auth', 'admin', 'desktop.only'])->group(function () {
    Route::get('/admin/backoffice', [AdminController::class, 'backoffice'])->name('admin.backoffice');
    Route::get("/admin/pending-vets", [AdminController::class, 'pendingVets'])->name('admin.pending-vets');
    Route::get("/admin/vet/{id}", [AdminController::class, 'vetDetail'])->name('admin.vet.detail');

    Route::post('/admin/vet/accept/{id}', [AdminController::class, 'vetAccept'])->name('admin.vet.accept');
    Route::post('/admin/vet/reject/{id}', [AdminController::class, 'vetReject'])->name('admin.vet.reject');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

    Route::patch('/admin/user/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.user.enable');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.disable');
});



require __DIR__.'/auth.php';
