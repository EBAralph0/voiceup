<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Demande;
use App\Notifications\DemandeCreated;
use App\Notifications\DemandeRejected;
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
        'statut' => "waiting",
    ]);

    try {
        Notification::route('mail', 'edracresurek@gmail.com')->notify(new DemandeCreated($demande));
        notify()->success("La demande pour $demande->nom_entreprise est en attente");
    } catch (\Swift_TransportException $e) {
        // \Log::error('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
        return redirect()->route('demandes.create')
            ->with('warning', 'Demande créée avec succès, mais un problème est survenu lors de l\'envoi du mail de notification.');
    } catch (\Exception $e) {
        // \Log::error('Erreur lors de la création de la demande : ' . $e->getMessage());
        return redirect()->route('demandes.create')
            ->with('error', 'Un problème est survenu lors de la création de la demande.');
    }

    return redirect()->route('demandes.create')->with('success', 'Demande créée avec succès.');
}


    public function index()
    {
        $demandes = Demande::orderBy('created_at', 'desc')->paginate(5);;
        return view('demandes.index', compact('demandes'));
    }

    public function show($id)
    {
        $demande = Demande::findOrFail($id);
        return view('demandes.show', compact('demande'));
    }

    public function reject($id)
{
    $demandes = Demande::all();
    $demande = Demande::findOrFail($id);
    $demande->statut = "rejected";
    $demande->save();

    try {
        Notification::route('mail', 'edracresurek@gmail.com')->notify(new DemandeRejected($demande));
        notify()->error("La demande pour $demande->nom_entreprise est rejetée");
    } catch (\Swift_TransportException $e) {
        // \Log::error('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
        return redirect()->route('demandes.index')
            ->with('warning', 'Demande rejetée, mais un problème est survenu lors de l\'envoi du mail de notification.');
    } catch (\Exception $e) {
        // \Log::error('Erreur lors du rejet de la demande : ' . $e->getMessage());
        return redirect()->route('demandes.index')
            ->with('error', 'Un problème est survenu lors du rejet de la demande.');
    }

    return view('demandes.index', compact('demandes'));
}

}
