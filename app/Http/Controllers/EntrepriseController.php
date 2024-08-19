<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise;
use App\Models\Secteur;
use App\Models\Demande;
use App\Models\User;
use App\Notifications\EntrepriseCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $secteurs = Secteur::all();
        $entreprises = Entreprise::when($request->sector_id, function ($query) use ($request) {
                return $query->where('id_secteur', $request->sector_id);
            })->paginate(5);

        return view('entreprises.index', compact('entreprises', 'secteurs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id)
    {
        //
        $demande = Demande::findOrFail($id);
        $secteurs = Secteur::all();
        return view('entreprises.create',compact('id','demande','secteurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id, int $proprietaire_id)
    {
        // Valider les données du formulaire
        $request->validate([
            'nom_entreprise' => 'unique:entreprises|required|string|max:255',
            'sigle' => 'required|string|max:255',
            'numero_entreprise' => 'unique:entreprises|required|string|max:255',
            'mail_entreprise' => 'unique:entreprises|required|email|max:255',
            'logo_entreprise' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'id_secteur' => 'required|string|max:255',
        ]);

        // Créer une nouvelle instance de Entreprise
        $entreprise = new Entreprise();
        $entreprise->fill($request->all());
        $entreprise->id_entreprise = Str::uuid()->toString();
        $entreprise->created_by_id = Auth::user()->id;
        $entreprise->proprietaire_id = $proprietaire_id;

        // Mettre à jour le statut de la demande
        $demande = Demande::findOrFail($id);
        $demande->statut = 'validated';

        // Mettre proprietaire à true et affecter le proprietaire à l'entreprise
        $proprietaire = User::findOrFail($proprietaire_id);
        $proprietaire->proprietaire = true;

        try {
            $entreprise->save();
            $demande->save();
            $proprietaire->save();

            // Tentative d'envoi de la notification par email
            try {
                Notification::route('mail', 'edracresurek@gmail.com')->notify(new EntrepriseCreated($entreprise));
            } catch (\Swift_TransportException $e) {
                // Gérer les erreurs de transport, comme les problèmes de connexion
                // \Log::error('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
                return redirect()->route('entreprises.index')
                    ->with('warning', 'L\'entreprise a été créée, mais un problème est survenu lors de l\'envoi du mail de notification.');
            }

            notify()->success("L'entreprise vient d'être créée !");
            return redirect()->route('entreprises.index')->with('success', 'Entreprise créée avec succès.');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTrace()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Entreprise $entreprise)
    {
        //
        return view('entreprises.show', compact('entreprise'));
    }

    public function list_questionnaire($id)
    {
        $entreprise = Entreprise::with('questionnaires')->findOrFail($id);
        return view('entreprises.list_questionnaire', compact('entreprise'));
    }

    public function detail($id)
    {
        $entreprise = Entreprise::with('questionnaires')->findOrFail($id);
        return view('entreprises.detail', compact('entreprise'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $secteurs = Secteur::all();
        return view('entreprises.edit', compact('entreprise', 'secteurs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'sigle' => 'required|string|max:255',
            'numero_entreprise' => 'required|string|max:255',
            'mail_entreprise' => 'required|email|max:255',
            'logo_entreprise' => 'nullable|string|max:255', // Assurez-vous que c'est une URL valide
            'slogan' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'id_secteur' => 'required|string|max:255',
        ]);

        $entreprise = Entreprise::findOrFail($id);
        $entreprise->update($request->all());

        return redirect()->route('entreprises.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entreprise $entreprise)
    {
        //
        $entreprise->delete();
        return redirect()->route('entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }


}
