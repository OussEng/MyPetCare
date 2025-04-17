<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RendezVousController;
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

    //Vaccination
    Route::get('/vaccinations/{id}', [AnimalController::class, 'list_vaccinations'])->name('vaccinations');
    Route::post('/vaccinations/{id}', [AnimalController::class, 'ajouter_vaccinations'])->name('vaccinations.add');
    Route::post('/animals/{animal_id}/vaccinations/{vaccination_id}/remove', [AnimalController::class, 'supprimer_vaccination'])->name('vaccination.remove');


    //Rendez-Vous
        //vet list
    Route::get('/rendez-vous', [RendezVousController::class, 'list_vets'])->name('list.vets');
        //Vet profile
    Route::get('/veterinaires/{id}', [RendezVousController::class, 'vet_profile'])->name('vet.profile');


    Route::get('/rendez/{id}', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::post('/rendez/{id}', [RendezVousController::class, 'store'])->name('rendez-vous.store');


});



require __DIR__.'/auth.php';
