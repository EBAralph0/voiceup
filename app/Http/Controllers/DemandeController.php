<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Demande;
use App\Notifications\DemandeCreated;
use Illuminate\Support\Facades\Notification;
use Laracasts\Flash\Flash;

use Illuminate\Http\Request;

class DemandeController extends Controller
{
    //
    public function create()
    {
        return view('demandes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
        ]);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'nom_entreprise' => $request->nom_entreprise,
        ]);


        Notification::route('mail', 'edracresurek@gmail.com')->notify(new DemandeCreated($demande));
        //notify()->success("La demande pour <span class='badge badge-dark'>{$demande->nom_entreprise}</span> est en attente");
        notify()->success("La demande pour $demande->nom_entreprise est en attente");
        return redirect()->route('demandes.create')->with('success', 'Demande  créée avec succès.');
    }

    public function index()
    {
        $demandes = Demande::all();
        return view('demandes.index', compact('demandes'));
    }

    public function show($id)
    {
        $demande = Demande::findOrFail($id);
        return view('demandes.show', compact('demande'));
    }
}
