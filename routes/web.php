<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepriseController;
use App\Models\Entreprise;
use App\Models\Demandes;
use App\Http\Controllers\DemandeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $entreprises = Entreprise::all();
    return view('welcome',compact('entreprises'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('entreprises', EntrepriseController::class)->except(['create', 'store']);
Route::get('/entreprises/create/{id}/{proprietaire_id}', [EntrepriseController::class, 'create'])->name('entreprises.create');
Route::post('/entreprises/{id}/{proprietaire_id}', [EntrepriseController::class, 'store'])->name('entreprises.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('demandes.show');
    Route::get('/demandes/reject/{id}', [DemandeController::class, 'reject'])->name('demandes.reject');
});
