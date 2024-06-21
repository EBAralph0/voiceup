<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Entreprise;

use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entreprises = Entreprise::all();
        return view('entreprises.index', compact('entreprises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('entreprises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Valider les données du formulaire
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'sigle' => 'required|string|max:255',
            'numero_entreprise' => 'required|string|max:255',
            'mail_entreprise' => 'required|email|max:255',
            'logo_entreprise' => 'required|string|max:255', // Assurez-vous que le fichier est une image et respecte les contraintes
            'slogan' => 'required|string|max:255', // Assurez-vous que le fichier est une image et respecte les contraintes
            'description' => 'required|string|max:255', // Assurez-vous que le fichier est une image et respecte les contraintes
            'secteur' => 'required|string|max:255', // Assurez-vous que le fichier est une image et respecte les contraintes

        ]);

        // Créer une nouvelle instance de Entreprise
        $entreprise = new Entreprise();
        $entreprise->fill($request->all());
        $entreprise->id_entreprise = Str::uuid()->toString();
        $entreprise->created_by_id = Auth::user()->id;

        try {
            $entreprise->save();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('entreprises.edit', compact('entreprise'));
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
        //
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
