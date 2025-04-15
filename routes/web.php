<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__.'/auth.php';
