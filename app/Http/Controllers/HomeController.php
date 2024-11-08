<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secteur;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         // Récupérer tous les secteurs et leurs entreprises avec les avis
         $secteurs = Secteur::with(['entreprises.avis'])->get();

         // Calculer la note moyenne des entreprises par secteur
         $secteurs = $secteurs->map(function ($secteur) {
             $entreprises = $secteur->entreprises->map(function ($entreprise) {
                 return [
                     'nom' => $entreprise->nom_entreprise,
                     'logo' => $entreprise->logo_entreprise ?? '/images/default_logo.png',
                     'averageRating' => round($entreprise->averageRating(), 1),
                     'avisCount' => $entreprise->avis->count()
                 ];
             })->sortByDesc('averageRating');

             return [
                 'nom_secteur' => $secteur->nom_secteur,
                 'entreprises' => $entreprises,
             ];
         });

         return view('home', compact('secteurs'));
    }
}
