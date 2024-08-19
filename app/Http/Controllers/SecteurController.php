<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Secteur;

class SecteurController extends Controller
{
    //
    public function index()
    {
        $secteurs = Secteur::paginate(5);
        return view('secteurs.index', compact('secteurs'));
    }

    public function edit($id)
    {
        $secteur = Secteur::findOrFail($id);
        return response()->json($secteur);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_secteur' => 'required|string|max:255',
        ]);

        $secteur = Secteur::findOrFail($id);
        $secteur->update($request->all());

        return redirect()->route('secteurs.index')->with('success', 'Secteur updated successfully');
    }

    public function destroy($id)
    {
        $secteur = Secteur::findOrFail($id);
        $secteur->delete();

        return redirect()->route('secteurs.index')->with('success', 'Secteur deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_secteur' => 'required|string|max:255',
        ]);

        $secteur = new Secteur();
        $secteur->id_secteur = Str::uuid();
        $secteur->nom_secteur = $request->nom_secteur;
        $secteur->save();

        return redirect()->route('secteurs.index')->with('success', 'Secteur created successfully');
    }
}
