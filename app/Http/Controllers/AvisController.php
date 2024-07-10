<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvisController extends Controller
{
    //
    public function create($entreprise_id)
    {
        $entreprise = Entreprise::findOrFail($entreprise_id);
        return view('avis.create', compact('entreprise'));
    }

    public function store(Request $request, $entreprise_id)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Avis::create([
            'user_id' => Auth::id(),
            'entreprise_id' => $entreprise_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('entreprises.show', $entreprise_id)->with('success', 'Avis ajouté avec succès.');
    }
}
