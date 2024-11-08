<?php

use Illuminate\Support\Facades\Route;
use App\Models\Entreprise;
use App\Models\Demandes;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\Avis;
use App\Models\Secteur;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ChoixController;

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


 Route::get('/entreprises/create/{id}', [EntrepriseController::class, 'create'])->name('entreprises.create');
 Route::post('/entreprises/{id}/{proprietaire_id}', [EntrepriseController::class, 'store'])->name('entreprises.store');
 Route::get('/entreprises/{id}/detail', [EntrepriseController::class, 'detail'])->name('entreprises.detail');
// Route pour afficher les détails de l'entreprise avec les questionnaires
 Route::get('/entreprises/{id}/list_questionnaire', [EntrepriseController::class, 'list_questionnaire'])->name('entreprises.list_questionnaire');


 Route::resource('entreprises', EntrepriseController::class)->except(['create', 'store']);


 Route::post('/questionnaire/{id}/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
 Route::get('/questionnaire/{id}/export-excel', [QuestionnaireController::class, 'exportExcel'])->name('questionnaire.exportExcel');

 Route::get('/search-companies', [EntrepriseController::class, 'search'])->name('companies.search');


Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('secteurs', SecteurController::class);

        Route::resource('users', UserController::class)->except(['show']);
        Route::put('/users/{id}/block', [UserController::class, 'block'])->name('users.block');
        Route::put('/users/{id}/unblock', [UserController::class, 'unblock'])->name('users.unblock');

        Route::get('/{id_secteur}/questionnaires/create', [QuestionnaireController::class, 'createForSector'])->name('secteurs.questionnaires.create');
        Route::post('/{id_secteur}/questionnaires', [QuestionnaireController::class, 'storeForSector'])->name('secteurs.questionnaires.store');
        Route::get('/secteurs/{id_secteur}/questionnaires', [QuestionnaireController::class, 'indexBySector'])->name('secteurs.questionnaires.index');
        Route::put('/questionnaires/{id}', [QuestionnaireController::class, 'update'])->name('questionnaires.update');
        Route::delete('/questionnaires/{id}', [QuestionnaireController::class, 'destroy'])->name('questionnaires.destroy');

        Route::get('/questionnaires/{id_questionnaire}/detail', [SecteurController::class, 'detail'])->name('secteurs.detail');
        Route::post('/questions/storeg/{questionnaire_id}', [QuestionController::class, 'storeg'])->name('questions.storeg');

        Route::post('/choixg/store/{question_id}', [QuestionController::class, 'storeChoixg'])->name('choix.storeg');
        Route::put('/choixug/{id}', [ChoixController::class, 'updateg'])->name('choix.updateg');
        Route::delete('/choixdg/{id}', [ChoixController::class, 'destroyg'])->name('choix.destroyg');

    });

    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('demandes.show');
    Route::get('/demandes/reject/{id}', [DemandeController::class, 'reject'])->name('demandes.reject');

    Route::get('/avis/{id}/avis/create', [AvisController::class, 'create'])->name('avis.create');
    Route::get('/get_all_avis', [AvisController::class, 'get_all'])->name('avis.get_all');
    Route::post('/avis/{id}/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::get('/analyze-avis/{id}', [AvisController::class, 'analyzeAvis'])->name('avis.analyze');




    Route::get('/questionnaires/create/{entreprise_id}', [QuestionnaireController::class, 'create'])->name('questionnaires.create');
    Route::post('/questionnaires/{entreprise_id}', [QuestionnaireController::class, 'store'])->name('questionnaires.store');
    Route::get('/questionnaires/{id}', [QuestionnaireController::class, 'detail'])->name('questionnaires.detail');

    Route::get('/questions/create/{questionnaire_id}', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store/{questionnaire_id}', [QuestionController::class, 'store'])->name('questions.store');
    Route::post('/choix/store/{question_id}', [QuestionController::class, 'storeChoix'])->name('choix.store');

    // Route pour afficher les questions d'un questionnaire
    Route::get('/questionnaires/{questionnaire}/questions/{entreprise}', [QuestionnaireController::class, 'showQuestions'])->name('questionnaires.questions');


    // Route pour soumettre les réponses
    Route::post('/questionnaires/{id}/questions/submit/{entreprise}', [ResponseController::class, 'submit'])->name('responses.submit');
    Route::get('/questionnaires/{id}/dashboard', [DashboardController::class, 'show'])->name('questionnaires.dashboard');


    Route::get('/choix/{id}/edit', [ChoixController::class, 'edit'])->name('choix.edit');
    Route::put('/choix/{id}', [ChoixController::class, 'update'])->name('choix.update');
    Route::delete('/choix/{id}', [ChoixController::class, 'destroy'])->name('choix.destroy');

    Route::get('/secteurs/{id_secteur}/compare', [EntrepriseController::class, 'compareBySector'])->name('secteurs.compare');



});

