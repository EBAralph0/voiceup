<?php

use Illuminate\Support\Facades\Route;
use App\Models\Entreprise;
use App\Models\Demandes;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;

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


 Route::get('/entreprises/create/{proprietaire_id}/{id}', [EntrepriseController::class, 'create'])->name('entreprises.create');
 Route::post('/entreprises/{proprietaire_id}/{id}', [EntrepriseController::class, 'store'])->name('entreprises.store');
 Route::get('/entreprises/{id}/detail', [EntrepriseController::class, 'detail'])->name('entreprises.detail');
// Route pour afficher les détails de l'entreprise avec les questionnaires
 Route::get('/entreprises/{id}/list_questionnaire', [EntrepriseController::class, 'list_questionnaire'])->name('entreprises.list_questionnaire');


 Route::resource('entreprises', EntrepriseController::class)->except(['create', 'store']);



Route::middleware(['auth'])->group(function () {
    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('demandes.show');
    Route::get('/demandes/reject/{id}', [DemandeController::class, 'reject'])->name('demandes.reject');

    Route::get('/questionnaires/create/{entreprise_id}', [QuestionnaireController::class, 'create'])->name('questionnaires.create');
    Route::post('/questionnaires/{entreprise_id}', [QuestionnaireController::class, 'store'])->name('questionnaires.store');
    Route::get('/questionnaires/{id}', [QuestionnaireController::class, 'detail'])->name('questionnaires.detail');

    Route::get('/questions/create/{questionnaire_id}', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store/{questionnaire_id}', [QuestionController::class, 'store'])->name('questions.store');
    Route::post('/choix/store/{question_id}', [QuestionController::class, 'storeChoix'])->name('choix.store');

    // Route pour afficher les questions d'un questionnaire
    Route::get('/questionnaires/{id}/questions', [QuestionnaireController::class, 'showQuestions'])->name('questionnaires.questions');

    // Route pour soumettre les réponses
    Route::post('/questionnaires/{id}/questions/submit', [ResponseController::class, 'submit'])->name('responses.submit');
});
